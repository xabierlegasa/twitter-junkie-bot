# Twitter Junkie Bot

A tiny project to post status messages into a specific twitter account.

In this case I am posting to @euskaltantak twitter account basque-spanish translations, but you can change the feed easily.

## Up and runnig

  - If you have a twitter account but you still don't have a Twitter app, create one: (<a href="http://iag.me/socialmedia/how-to-create-a-twitter-app-in-8-easy-steps/">a tutorial here</a>
    * Log into your twitter account and go to: <a target="_blank" href="https://apps.twitter.com/">https://apps.twitter.com/</a>
    * Click on 'Create New App' and fill in Name, Description and Website. (Fallback url is not necessary)
    * Enter into your new Twitter App, and go to 'Keys and Access Tokens'.
    * Click on 'Generate Consumer Key and Secret' with Read and Write permissions.
    * Done. You will need: Consumer Key, Consumer Secret, Access Token and Access Token Secret.
  - Project set up is easy:
    * git clone git@github.com:xabierlegasa/twitter-junkie-bot.git twitter-junkie-bot
    * cd twitter-junkie-bot
    * composer install
    * cp config/twitter_credentials_EXAMPLE.json config/twitter_credentials.json
    * Set correct credentials from step one on config/twitter_credentials.json file
  - Post to twitter
    * This posts a message to the account: php web/post_status_to_twitter.php


## I want to post something else

You have to implement this simple interface: src/Feed/TwitterFeed.php

```php
<?php
namespace TwitterJunkieBot\Feed;
interface TwitterFeed
{
    /** Get a status message to be posted in twitter
     * @return string
     */
    public function getStatusMessage();
}
```

In my case, I created: src/Feed/TwitterFeedBasqueDictionary.php which will use a
basque-spanish translation dictionary json to build a message. But you can create your own and change
this file, web/post_status_to_twitter.php injecting your own implementation