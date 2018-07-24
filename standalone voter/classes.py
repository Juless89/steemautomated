from steem.post import Post
from datetime import datetime

import json


class Queue:
    def __init__(self, account, steem, upvote_age):
        self.queue = []
        self.upvote_list = json.load(open('upvote_list.json'))
        self.account = account
        self.upvoted = {}
        self.upvotes = 0
        self.total_upvoted = 0.0
        self.steem = steem
        self.upvote_age = upvote_age

    # Check how many upvotes the author has received so far if the limit
    # has been reached.
    def limit_reached(self, author):
        upvote_limit = self.upvote_list[author]["upvote_limit"]
        upvote_weight = self.upvote_list[author]["upvote_weight"]

        if author not in self.upvoted:
            self.upvoted[author] = 0

        upvoted = self.upvoted[author]
        print(f'Limit: {upvoted}/{upvote_limit} weight: {upvote_weight}')

        if author not in self.upvoted:
            return False
        elif self.upvoted[author] == upvote_limit:
            return True
        else:
            return False

    # Verify that the athor is in the upvote list and the post is eligeble for
    # upvoting.
    def valid_post(self, post):
        author = post['author']

        if (post.is_main_post()
            and author in self.upvote_list
                and not self.limit_reached(author)):
            return True
        else:
            return False

    # Every new block check how old the queued posts are. When older than
    # upvote_age remove the post from the queue and process the post for voting
    def process_queue(self, now):
        t1 = datetime.strptime(now, '%Y-%m-%dT%H:%M:%S')

        i = 0
        while i < len(self.queue):
            timestamp, post = self.queue[i]
            t2 = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')
            delta = (t1-t2).total_seconds()

            if delta > self.upvote_age:
                timestamp, post = self.queue.pop(i)
                self.process_vote(post)
            else:
                break

    # Upvote the post with the variables set by the user.
    def process_vote(self, post):
        author = post["author"]
        identifier = post['identifier']
        upvote_weight = self.upvote_list[author]["upvote_weight"]
        account = self.account

        print(f"\nUpvoting {author}\nPermlink: {identifier}")

        self.steem.vote(identifier, upvote_weight, account)
        self.upvotes += 1
        self.total_upvoted += upvote_weight
        self.upvoted[author] += 1

        print(f"Upvoted {author} for {upvote_weight}%")
        print(f"Daily upvotes: {self.upvotes} for {self.total_upvoted}%\n")

    # Filter for updated posts and posts which are already upvoted by the
    # account.
    def already_upvoted(self, post):
        active_votes = post['active_votes']
        identifier = post['identifier']
        author = post['author']
        created = post['created']
        last_update = post['last_update']
        valid = 1

        if created != last_update:
            print(f'\n{author} {identifier}\nUpdated post\n')
            return 0

        print(f'\n{author} {identifier}')
        for vote in active_votes:
            if vote['voter'] == self.account:
                print(f'Already upvoted {author} {identifier}\n')
                return 0

        return valid

    # Add the post with its timestamp to the queue as a tuple
    def add_to_queue(self, identifier, timestamp):
        post = Post(identifier, self.steem)
        valid = self.already_upvoted(post)

        if valid == 1 and self.valid_post(post):
            self.queue.append((timestamp, post))
            print('Added to queue\n')

    # Reset all daily variables
    def reset(self):
        self.upvoted = {}
        self.queue = []
        self.upvotes = 0
        self.total_upvoted = 0.0
