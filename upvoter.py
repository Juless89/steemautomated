from steem.blockchain import Blockchain
from steem import Steem
from datetime import datetime

import os
import json
import sys
import time
import classes


class Upvotebot():
    def __init__(self, account):
        self.block = None
        self.node_index = 0
        self.list = ['https://api.steemit.com',
                     'https://rpc.buildteam.io',
                     'https://rpc.steemviz.com']
        self.nodes = [self.list[self.node_index]]
        self.steemPostingKey = os.environ.get('steemPostingKey')
        self.steem = Steem(wif=self.steemPostingKey, nodes=self.nodes)
        self.b = Blockchain(self.steem)

        self.account = account
        self.upvote_list = json.load(open('upvote_list.json'))

        self.day = None
        self.hour = None

        self.queue = classes.Queue(account, self.steem)

        print('Running photobot \nConnected to: {}'.format(self.nodes[0]))

    def set_times(self, datetime_object):
        self.day = datetime_object.day
        self.hour = datetime_object.hour

        print('Block times set')

    def time_handler(self, datetime_object):
        if not self.day and not self.hour:
            self.set_times(datetime_object)

        day = datetime_object.day
        hour = datetime_object.hour

        if day is not self.day:
            print("\nNew day: cleared memory\n")

            self.queue.reset()
            self.day = day

        if hour is not self.hour:
            print("\nNew hour: reloaded upvote list\n")

            self.upvote_list = json.load(open('upvote_list.json'))
            self.hour = hour

    def process_operation(self, operation, timestamp):
        parent_author = operation['operations'][0][1]['parent_author']

        if parent_author == '':
            author = operation['operations'][0][1]['author']
            permlink = operation['operations'][0][1]['permlink']
            identifier = '@{}/{}'.format(author, permlink)

            if author in self.upvote_list:
                self.queue.add_to_queue(identifier, timestamp)

    def reconfigure_node(self):
        self.node_index = (self.node_index + 1) % len(self.list)
        self.nodes = [self.list[self.node_index]]
        self.steem = Steem(wif=self.steemPostingKey, nodes=self.nodes)
        self.b = Blockchain(self.steem)
        self.queue.steem = self.steem

        print('New node: {}\n'.format(self.nodes))

    def run(self, block_num, upvote_age):
        if block_num == 'head':
            self.block = self.blockchain.get_current_block_num()
        else:
            self.block = int(block_num)

        self.queue.upvote_age = upvote_age * 60

        while True:
            try:
                stream = self.b.stream_from(start_block=self.block,
                                            full_blocks=True)
                for block in stream:
                    timestamp = block['timestamp']
                    print(self.block, timestamp)
                    self.queue.process_queue(timestamp)
                    datetime_object = datetime.strptime(timestamp,
                                                        '%Y-%m-%dT%H:%M:%S')

                    self.time_handler(datetime_object)

                    for operation in block['transactions']:
                        operation_type = operation['operations'][0][0]

                        if operation_type == 'comment':
                            self.process_operation(operation, timestamp)

                    self.block += 1

            except Exception as e:
                s = ("TypeError('an integer is"
                     " required (got type NoneType)',)")
                if repr(e) == s:
                    time.sleep(3)
                else:
                    print(self.block, repr(e))
                    self.reconfigure_node()
                    continue


if __name__ == '__main__':
    try:
        block_num = sys.argv[2]
        upvote_age = int(sys.argv[3])
        account = sys.argv[1]
        upvoter = Upvotebot(account)
        upvoter.run(block_num, upvote_age)
    except Exception as e:
        print('Takes 3 arguments: <account> <block_num> <upvote_age>')
        print('Use head to stream from current head block')
        print('Upvote age is in minutes')
