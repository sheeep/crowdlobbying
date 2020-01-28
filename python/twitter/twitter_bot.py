#!/usr/bin/env python3

import configparser
import sys
import datetime

import tweepy
import imgkit

config = configparser.ConfigParser()
config.read('twitterconfig.ini')

consumer_key = config['DEFAULT']['ConsumerApiKey']
consumer_secret = config['DEFAULT']['ConsumerApiSecretKey']
access_token = config['DEFAULT']['AccessToken']
access_token_secret = config['DEFAULT']['AccessTokenSecret']

auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)
api = tweepy.API(auth)


sr = sys.argv[1]
name = sys.argv[2]
party = sys.argv[3]

if len(sys.argv) == 5:
    image = sys.argv[4]
    imgkit.from_file('../../data/card.html', '../../data/card.jpg')

interval = config['DEFAULT']['Interval']

# check for party activity
if party in config['PARTY']:
    last_time = config['PARTY'][party]

    print(datetime.datetime.now() - datetime.datetime.strptime(last_time, '%Y-%m-%d %H:%M:%S.%f'))

    if not (datetime.datetime.now() - datetime.datetime.strptime(last_time, '%Y-%m-%d %H:%M:%S.%f')).seconds > int(interval):
        print('To soon')
        sys.exit(1)

cfgfile = open("twitterconfig.ini",'w')
config['PARTY'][party] = str(datetime.datetime.now())
config.write(cfgfile)
cfgfile.close()

message = 'Nachricht an {} {} {} #eID #crowdlobbying www.crowdlobbying.ch'.format(sr, name, party)

if len(sys.argv) == 5:
    filename = '../../data/card.jpg'
    api.update_with_media(filename, status=message)
else:
    api.update_status(message)

print(message)
user = api.me()
print (user.name)
