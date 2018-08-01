# Developed by @juliank https://www.steemit.com/@juliank
# This file contains all database interaction for Steemautomated
# https://github.com/Juless89/steemautomated

from datetime import datetime
from datetime import timedelta
import MySQLdb

HOST = "localhost"
USER = ""
PASSWD = ""
DB = ""


class Database():
    def __init__(self):
        self.db = None
        self.cur = None
        self.debug = False

    def connect_to_db(self):
        self.db = MySQLdb.connect(
            host=HOST,
            user=USER,
            passwd=PASSWD,
            db=DB,
        )
        self.cur = self.db.cursor()

    def close_connection(self):
        self.cur.close()
        self.db.close()

    def get_queue(self):
        query = "SELECT * FROM `vote_queue` ORDER BY `expire_on` ASC;"
        return self.get_data(query)

    def get_votes(self, author):
        query = (f"SELECT `user_login`,`upvoteweight`,`upvotelimit`," +
                 "`upvotedelay` FROM `wp_wpdatatable_1` t1 INNER JOIN " +
                 "`wp_users` t2 ON t1.voter = t2.id WHERE " +
                 f"`author` = '{author}';")
        return self.get_data(query)

    def get_authors(self):
        query = "SELECT DISTINCT `author` FROM `wp_wpdatatable_1`;"
        return self.get_data(query)

    def get_user_auth(self, voter):
        query = ("SELECT `access_token`,`refresh_token`,`expires_in` FROM " +
                 f"`steem_authorization` WHERE `user_login` = '{voter}'")
        return self.get_data(query)

    def get_trail_log(self, voter, trail, timestamp):
        dt = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')
        today = dt.date()
        tomorrow = today + timedelta(days=1)

        query = (f"SELECT `id` FROM `trail_log` WHERE `voter` = '{voter}' " +
                 f"AND `trail` = '{trail}' AND  `timestamp` >= '{today}' " +
                 f"AND `timestamp` < '{tomorrow}';")
        return self.get_data(query)

    def get_vote_log(self, voter, author, timestamp):
        dt = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')
        today = dt.date()
        tomorrow = today + timedelta(days=1)

        query = (f"SELECT `id` FROM `vote_log` WHERE `voter` = '{voter}' " +
                 f"AND `author` = '{author}' AND  `timestamp` >= '{today}' " +
                 f"AND `timestamp` < '{tomorrow}';")
        return self.get_data(query)

    def get_trail_voters(self, trail):
        query = (
            "SELECT `user_login`,`upvoteweight`,`upvotelimit`,`upvotedelay` " +
            "FROM `wp_wpdatatable_2` t1 INNER JOIN `wp_users` t2 on " +
            f"t1.voter = t2.id  WHERE `trail` = '{trail}';")
        return self.get_data(query)

    def get_trails(self):
        query = "SELECT DISTINCT `trail` FROM `wp_wpdatatable_2`"
        return self.get_data(query)

    def add_to_trail_log(
        self, trail, author, voter,
        permlink, weight, timestamp
    ):
        query = (
            "INSERT INTO `trail_log` (`id`, `trail`, `voter`, `author`, " +
            "`permlink`, `weight`, `timestamp`) VALUES (NULL, " +
            f"'{trail}', '{voter}', '{author}', '{permlink}', '{weight}', " +
            f"'{timestamp}');")
        self.post_data(query, 'trail_log')

    def add_to_vote_log(self, author, voter, permlink, weight, timestamp):
        query = (f"INSERT INTO `vote_log` (`id`, `voter`, `author`, " +
                 "`permlink`, `weight`, `timestamp`) VALUES (NULL, " +
                 f"'{voter}', '{author}', '{permlink}', '{weight}', " +
                 f"'{timestamp}');")
        self.post_data(query, 'vote_log')

    def add_trail_to_queue(
        self, trail, author, voter, weight,
        limit, delay, permlink, timestamp,
    ):
        dt = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')

        if len(self.get_trail_log(voter, trail, timestamp)) < limit:
            expire_on = dt + timedelta(minutes=delay)
            query = (
                f"INSERT INTO `vote_queue` (`id`, `voter`, `author`, " +
                "`permlink`, `weight`, `type`,`expire_on`) VALUES (NULL, " +
                f"'{voter}', '{author}', '{permlink}', '{weight}', " +
                f"'trail', '{expire_on}');")
            self.post_data(query, 'vote_queue')
            self.add_to_trail_log(
                trail, author, voter,
                permlink, weight, expire_on,
            )
            print("Added to queue\n")
        else:
            print("Reached daily limit\n")

    def add_to_queue(self, author, voter, weight, limit, delay, permlink,
                     timestamp):
        dt = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')

        if len(self.get_vote_log(voter, author, timestamp)) < limit:
            expire_on = dt + timedelta(minutes=delay)
            query = (f"INSERT INTO `vote_queue` (`id`, `voter`, `author`, " +
                     "`permlink`, `weight`, `expire_on`) VALUES (NULL, " +
                     f"'{voter}', '{author}', '{permlink}', '{weight}', " +
                     f"'{expire_on}');")
            self.post_data(query, 'vote_queue')
            self.add_to_vote_log(author, voter, permlink, weight, expire_on)
            print("Added to queue\n")
        else:
            print("Reached daily limit\n")

    def add_to_error_log(self, voter, author, permlink, weight, type, message,
                         timestamp):
        query = (
            'INSERT INTO `error_log` (`id`, `voter`, `author`, ' +
            '`permlink`, `weight`, `type`, `error`, `timestamp`) VALUES ' +
            f'(NULL, "{voter}", "{author}", "{permlink}", ' +
            f'"{weight}", "{type}", "{message}", "{timestamp}");')
        self.post_data(query, 'error_log')
        print(f"Vote failed: {message}\n")

    def update_log(self, voter, permlink, message, type):
        query = (f"SELECT `id` FROM `{type}` WHERE `voter` = '{voter}' " +
                 f"AND `permlink` = '{permlink}';")
        result = self.get_data(query)[0]
        vote_id = result[0]

        query = (f"UPDATE `{type}` SET `voted` = '{message}' WHERE " +
                 f"`{type}`.`id` = {vote_id};")
        self.post_data(query, type)

    def update_authentication_tokens(self, voter, access_token, refresh_token,
                                     expires_in, timestamp):
        dt = datetime.strptime(timestamp, '%Y-%m-%dT%H:%M:%S')
        expires_in = dt + timedelta(seconds=expires_in)

        query = ("UPDATE `steem_authorization` SET `access_token` = " +
                 f"'{access_token}', `expires_in` = '{expires_in}', " +
                 f"`refresh_token` = '{refresh_token}' WHERE " +
                 f"`user_login` = '{voter}';")
        self.post_data(query, 'steem_authorization')

    def remove_from_queue(self, id):
        query = f"DELETE FROM `vote_queue` WHERE `vote_queue`.`id` = {id};"
        self.post_data(query, 'vote_queue')

    # Insert date, amount into table 'table'. Look if the record already
    # exists, update if needed else add.
    def post_data(self, query, table):
        if self.debug:
            print(query)

        try:
            self.connect_to_db()

            # Lock table
            self.cur.execute(f"LOCK TABLES {table} WRITE;")
            self.cur.execute(query)

            # Release table
            self.cur.execute(f"UNLOCK TABLES;")

            # Commite changes made to the db
            self.db.commit()

        except Exception as e:
            print('Error:', e)

        finally:
            # Close connections
            self.close_connection()

    def get_data(self, query):
        if self.debug:
            print(query)

        try:
            # Connect to DB and execute query
            self.connect_to_db()
            self.cur.execute(query)

            # Fetch results
            rows = self.cur.fetchall()

            # Commite changes made to the db
            self.db.commit()
        except Exception as e:
            print('Error:', e)

        finally:
            # Close connections
            self.close_connection()
            return rows
