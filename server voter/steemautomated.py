# Developed by @juliank https://www.steemit.com/@juliank
# This is the main file for Steemautomated
# Containing all interactions with the STEEM Blockchain
# https://github.com/Juless89/steemautomated

from steem.blockchain import Blockchain
from steem import Steem
from datetime import datetime
from steem.post import Post
from steemconnect.client import Client
from steemconnect.operations import Vote

import os
import time
import database
import re

CLIENT_ID = ""
CLIENT_SECRET = ""

class Upvotebot():
    def __init__(self):
        self.node_index = 0
        self.nodes = ['https://api.steemit.com',
                      'https://rpc.buildteam.io',
                      'https://rpc.steemviz.com']
        self.steemPostingKey = os.environ.get('steemPostingKey')
        self.steem = Steem(wif=self.steemPostingKey, nodes=self.nodes)
        self.b = Blockchain(self.steem, mode='head')
        self.block = self.b.get_current_block_num()

        self.upvote_list = []
        self.trail_list = []
        self.day = None
        self.hour = None
        self.timestamp = None

        self.db = database_debug.Database()

    # Voting is done via Steemconnect with the steemconnect plugin from
    # @emre: https://github.com/emre/steemconnect-python-client
    # Set client_id and client_sercret
    # Sign up at: https://v2.steemconnect.com/dashboard
    #
    # To perform a vote the access_token is fetched from the DB and checked
    # to not be expired, if so it is renewed and stored inside the DB.
    # Votes are then removed from the queue and their log is updated.
    # When a vote fails it gets added to the error database for manual review.
    def vote(self, voter, author, permlink, weight, type):
        result = self.db.get_user_auth(voter)
        access_token, refresh_token, expire_on = result[0]
        dt = datetime.now()
        c = Client(
                client_id=CLIENT_ID,
                client_secret=CLIENT_SECRET,
                access_token=access_token,
            )

        try:
            # Verify access_token
            if dt > expire_on:
                access_token = self.refresh_token(refresh_token)
                result = c.refresh_access_token(
                            refresh_token,
                            "login,vote"  # scopes
                )
                access_token = result['access_token']
                refresh_token = result['refresh_token']
                expires_in = result['expires_in']
                self.db.update_authentication_tokens(
                    voter,
                    access_token,
                    refresh_token,
                    expires_in,
                    self.timestamp,
                )
                print('Updated access token\n')

            # Perform vote
            if not self.is_already_voted(voter, author, permlink):
                vote = Vote(voter, author, permlink, weight)
                result = c.broadcast([vote.to_operation_structure()])

            # Log vote
            if 'error' in result:
                message = result['error_description']
                self.db.add_to_error_log(
                    voter, author, permlink, weight, type,
                    message, self.timestamp,
                 )
            else:
                message = 'Succes'
                if type == 'vote':
                    self.db.update_log(
                        voter, permlink, message, 'vote_log',
                        )
                elif type == 'trail':
                    self.db.update_log(
                        voter, permlink, message, 'trail_log',
                    )
                print(f"Voter: {voter}\nAuthor: {author}\n" +
                      f"Permlink: {permlink}\nWeight: {weight}\n" +
                      "Upvote succes\n")
        except Exception as error:
            print(voter, author, permlink, weight, error)
            self.db.add_to_error_log(
                    voter, author, permlink,
                    weight, type, error, self.timestamp,
            )

    # Trails with a delay of 0 are immediatly voted upon. Else the expire_on
    # time of the vote is calculated and added to the queue. The weight of
    # vote is relative between the weight of the vote casted by the voter that
    # is being trailed and the trailer who has set a custom relative weight.
    def add_trail_to_queue(self, trail, author, permlink, weight):
        for voter in self.db.get_trail_voters(trail):
            voter, voter_weight, limit, delay = voter
            vote_log = self.db.get_trail_log(voter, trail, self.timestamp)
            upvote_weight = weight/100 * voter_weight/100
            print(f"\nTrail: {trail}\nVoter: {voter}\nAuthor: {author}\n" +
                  f"Weight: {upvote_weight}\nLimit: {limit}\nDelay: {delay}\n")

            if delay != 0:
                self.db.add_trail_to_queue(
                    trail, author, voter, upvote_weight, limit, delay,
                    permlink, self.timestamp,
                )
            elif len(vote_log) < limit:
                self.db.add_to_trail_log(
                    author, voter, permlink,
                    upvote_weight, self.timestamp,
                )
                self.vote(voter, author, permlink, weight, type)

    # The time for when a vote is to be made is calculated from the current
    # block time + the delay. If the delay is 0 an immediate vote is performed.
    # Votes get added to the queue and log
    def add_to_queue(self, author, permlink):
        for vote in self.db.get_votes(author):
            voter, weight, limit, delay = vote
            vote_log = self.db.get_vote_log(voter, author, self.timestamp)
            print(f"\nVoter: {voter}\nWeight: {weight}\nLimit: " +
                  f"{limit}\nDelay: {delay}")

            if delay != 0:
                self.db.add_to_queue(
                    author, voter, weight, limit, delay,
                    permlink, self.timestamp,
                )
            elif len(vote_log) < limit:
                self.db.add_to_vote_log(
                    author, voter, permlink,
                    weight, self.timestamp,
                    )
                self.vote(voter, author, permlink, weight, type)

    # Go thourgh all the active votes and look if the voter has already
    # voted on this post.
    def is_already_voted(self, voter, author, permlink):
        try:
            identifier = f"@{author}/{permlink}"
            post = Post(identifier, self.steem)
            active_votes = post['active_votes']
            for vote in active_votes:
                if vote['voter'] == voter:
                    return 1
            return 0
        except Exception as error:
            return 0

    # Posts are verified to be the initial post and not an update
    def is_new_post(self, author, permlink):
        identifier = f"@{author}/{permlink}"
        post = Post(identifier, self.steem)
        created = post['created']
        last_update = post['last_update']

        if created != last_update:
            return 0
        else:
            return 1

    # Comment is checked to be of the post type and not a comment to a post.
    # Posts are then added to queue
    def process_comment(self, comment):
        parent_author = comment['parent_author']
        author = comment['author']

        if parent_author == '' and author in self.upvote_list:
            permlink = comment['permlink']
            if self.is_new_post(author, permlink):
                print(f'\n\n{self.timestamp} Block: {self.block}')
                print(f"New post\nAuthor: {author}")
                self.add_to_queue(author, permlink)

    # Votes are checked for their voter and if the voter is being trailed
    def process_vote(self, vote):
        trail = vote['voter']

        if trail in self.trail_list:
            author = vote['author']
            permlink = vote['permlink']
            weight = vote['weight']
            print(f"\n\nTrail: {trail}\nAuthor: {author}\nPermlink: " +
                  f"{permlink}\nWeight: {weight}\n")

            self.add_trail_to_queue(trail, author, permlink, weight)

    # Each block the queue is fetched and checked for votes that have reached
    # their maturity time.
    def process_queue(self):
        dt = datetime.strptime(self.timestamp, '%Y-%m-%dT%H:%M:%S')
        result = self.db.get_queue()

        if len(result) > 0:
            for vote in result:
                id, voter, author, permlink, weight, type, expire_on = vote
                if dt > expire_on:
                    self.vote(voter, author, permlink, weight, type)
                    self.db.remove_from_queue(id)

    # Stream block indefinitely, process each block for comments
    # Stream is set to head mode
    def run(self):
        stream = self.b.stream_from(
            start_block=self.block,
            full_blocks=True,
        )

        while True:
            try:
                for block in stream:
                    # Set block time and process queue
                    self.timestamp = block['timestamp']
                    print(f'{self.timestamp} Block: {self.block}', end='\r')
                    self.process_queue()

                    # Fetch author to be upvoted list
                    self.upvote_list = []
                    for author in self.db.get_authors():
                        author = re.sub(
                            '[^A-Za-z0-9^-]+', '',
                            author[0].lower(),
                        )
                        self.upvote_list.append(author)

                    # Fetch trails to be tracked
                    self.trail_list = []
                    for trail in self.db.get_trails():
                        trail = re.sub(
                            '[^A-Za-z0-9^-]+', '',
                            trail[0].lower(),
                        )
                        self.trail_list.append(trail)

                    # Look at each single transaxtion
                    for transaction in block['transactions']:
                        transaction_type = transaction['operations'][0][0]
                        if transaction_type == 'comment':
                            comment = transaction['operations'][0][1]
                            self.process_comment(comment)
                        elif transaction_type == 'vote':
                            vote = transaction['operations'][0][1]
                            self.process_vote(vote)

                    self.block += 1

            except Exception as e:
                print(e)
                # common exception for api.steemit.com
                # when the head block is reached
                s = ("TypeError('an integer is"
                     " required (got type NoneType)',)")
                if repr(e) == s:
                    time.sleep(1)
                else:
                    stream = self.b.stream_from(
                        start_block=self.block,
                        full_blocks=True,
                    )
                    continue


if __name__ == '__main__':
    upvoter = Upvotebot()
    upvoter.run()
