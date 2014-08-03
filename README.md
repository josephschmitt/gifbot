# Gifbot for Slack

Gifs for your [Slack](https://slack.com) channel.

Do you find that you cannot properly and completely express yourself unless it's done in animated form? You're not alone! Gifbot is here to help.

## What is Gifbot?

Gifbot is a set of integrations for Slack that allow you to easily post animated gifs to your Slack channel using [Giphy](http://gifphy.com)'s excellent gif search API. It'll take a search term you provide and use that to try to find the most appropriate animated gif related to that term. It'll then display that gif directly inside your Slack channel.

## How does it work?

Once installed, simply type `/gif` followed by a search term and instantly see a fantastic animated gif:

![](http://cl.ly/Wrvs/image.gif)

Sometimes they're exactly what you wanted, sometimes they're not, but they're *always* entertaining.

## Alright, I NEED this. Like, NOW. HOW DO I GET THIS INSTALLED??

Woah, woah, slow down there tiger. You'll need a few things to get this up and running:

1. A [Slack](http://slack.com) account and team, obviously. If you don't have Slack yet, get on it. It's great.
2. A webserver that can run PHP 5.3.x or higher and upload access to that server.
3. A little bit of familiarity with setting up Slack integrations (and permission to do so).

All set? Good, let's set up your very own Gifbot!

## Slack Integration Setup

Let's start by setting up your Slack integrations to work with Gifbot. The first thing we need to set up is the command you'll use to trigger Gifbot, called a Slash Command.

1. Head on over to Slack and [add a new integration](http://slack.com/services/new)
2. Scroll down to and add a new Slash Command  
   ![](http://cl.ly/WsJY/image.png)
3. Fill in the information under "Settings".
	1. For command, enter in '/gif'.
	2. For URL, point it to wherever you'll be hosting the gifbot.php file from this repository.
	3. The other two don't really matter.
4. Save the integration.

Next, we need to set up an Incoming Webhook, which will handle displaying the gif results from the Giphy API in your channel.

1. Head back to the integrations and [add another new integration](http://slack.com/services/new)
2. Scroll down and add a new Incoming Webhook.  
   ![](http://cl.ly/Wrob/image.png)  
   Make sure you choose incoming, and not outgoing.
3. Choose a default channel for the webhook. Honestly, this option won't really matter since Gifbot will read the channel the slash command goes out to. The best option is to choose @slackbot so that it'll work with DMs with the Slackbot.
4. Add the webhook.
5. Note and set aside the url under "Your Unique Webhook URL". We'll need this in a second.
6. Scroll down to Integration Settings and expand it.
7. Click on the link to "change the icon" and give it a custom icon, like this one: https://github.com/Giphy/GiphyAPI/raw/master/api_giphy_logo_sparkle_clear.gif. This is completely optional, but it'll make your bot look extra cool.
8. Save the integration.

Congrats, Slack is now setup to work with Gifbot! Now, let's get your Gifbot set up on your server.

1. Open up the `config.php` file.
2. Change the value of the `webhook_url` property to be that "Your Unique Webhook URL" we set aside earlier.
3. Upload the contents of the repository to your web server. Make sure the URL you specified to Slack when setting up your Slash Command points to the gifbot.php file on your server.

That's it, you're done! Head on over to a Slack channel, type in "/gif thumbs up" (without the quotes) and see what happens. Happy gif'ing!

## Optional Configuration Settings

The `config.php` file has a few extra options you can change:

**translate**  
(Boolean) Whether to use the Translation API (the default) or the standard search API. If you opt out of the Translation API, gifbot will use the normal search API to get the top 25 results from Giphy and choose one from those at random. More information about the difference can be found on Giphy's API docs: https://github.com/giphy/GiphyAPI#translate-endpoint

**botname**  
(String) The name displayed in Slack for the bot. Defaults to 'gifbot'.

**show_name**  
(Boolean) Whether or not to show the name of the Slack user that requested the gif after the botname. Eg. 'gifbot :: joe'.

**giphy_api_key**  
Giphy API key. Defaults to the public Giphy API key but if you run into their usage limits you might need to register for your own.
