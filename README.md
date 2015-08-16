# Twitter Junkie Bot

A tiny project to post status messages into a specific twitter account.
In this case I am posting to @euskaltantak twitter account basque-spanish translations.

## Up and runnig

  - If you have a twitter account but do not have a Twitter app yet, create one:
    * Log into your twitter account and go to: https://apps.twitter.com/
    * Click on 'Create New App' and fill in Name, Description and Website. (Fallback url is not necessary)
    * Enter into your new Twitter App, and go to 'Keys and Access Tokens'.
    * Click on 'Generate Consumer Key and Secret' with Read and Writte permissions.
    * Done. You will need: Consumer Key, Consumer Secret, Access Token and Access Token Secret.
  - Clone the project and set up
    * git clone git@github.com:xabierlegasa/twitter-junkie-bot.git
    * cd twitter-junkie-bot.git
    * composer install
    * cp config/twitter_credentials_EXAMPLE.json config/twitter_credentials.json
    * Set correct credentials from step one on config/twitter_credentials.json file
