# Fully automated STEEM voter
---

## Requirements

Steem-python is required
https://github.com/steemit/steem-python

With pip:

```
pip3 install steem      # pip install steem for 2.7
```

From Source:

```
git clone https://github.com/steemit/steem-python.git
cd steem-python
python3 setup.py install        # python setup.py install for 2.7
```

## Installation

From source:

```
git clone https://github.com/Juless89/fully-automated-steemvoter
```

## Usage

Requires 3 arguments:
- account to be used for voting
- block number to start or head to use current head block
- upvote age for posts in minutes

```
python upvoter.py <account> <block_number|head> <upvote_age>
```

## Upvote list

All accounts to be upvoted must be added in JSON format to upvote_list.json. Each account requires the account name, the weight up the votes and the limit of votes per day.

```
"steempytutorials": {
  "upvote_weight": 100,
  "upvote_limit": 1
}
```

## Road map

- vote trailing
- specific delay per user
- downvoting
- dynamic voting based on current voting power
- batched upvoting
- multiple accounts
- following a hashtag + whitelist
- leave configurable comments
