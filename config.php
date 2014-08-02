<?php

/*

---------------------------------------
Gifbot Slack Integration
---------------------------------------

You need to change the following values in order to get Gifbot working
with your Slack channel.

webhook_token:	(String) The url from your incoming webhook integration.

*/

c::set('webhook_url', 'http://your_unique_webhook_url');

/*

---------------------------------------
Gifbot Config
---------------------------------------

Feel free to change these defaults that control how gifbot is
displayed in the Slack channel as well as what gifs it picks.

translate: 		(Boolean) Whether to use the Translation API or the
				standard search API. More information about the 
				difference can be found on Giphy's site: 
				https://github.com/giphy/GiphyAPI#translate-endpoint

botname:   		(String) The name displayed in Slack for the bot. 
				Defaults to 'gifbot'.

show_name:		(Boolean) Whether or not to show the name of the Slack
				user that requested the gif after the botname. Eg.
				'gifbot :: joe'.

giphy_api_key:	Giphy API key. Defaults to the public Giphy API key
				but if you run into their usage limits you might
				need to register for your own.

*/
c::set('translate', true);
c::set('botname', 'gifbot');
c::set('show_name', true);

c::set('giphy_api_key', 'dc6zaTOxFJmzC');