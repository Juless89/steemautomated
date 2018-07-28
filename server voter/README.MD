# Steemautomated server voter
---
## About

This is the server application that handles all the interactions with the STEEM Blockchain, steemconnect and the website database.

## Requirements

- python 3.6
- steem-python
- steemconnect

With pip:

```
pip3 install steem
pip3 install steemconnect
```



## Installation

From source:

```
git clone https://github.com/Juless89/steemautomated/tree/master/server%20voter
```


## Set up

Inside `steemautomated.py` the Steemconnect app access_code and client_id must be set. And inside `database.py` the user, password en database have to be set for the MySQL database. Add new tables to the existing database.

## Run

Make a tmux session to run the code in:

```
tmux new -s steemautomated
python steemautomated.py
```
