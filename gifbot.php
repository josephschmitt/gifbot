<?php
require_once('toolkit/bootstrap.php');

$text = r::get($_GET['text'], '');
$user_name = r::get('user_name', '');
$channel_name = r::get('channel_name', '');

$webhook_token = c::get('webhook_token');
$room_url = c::get('team_url') . 'services/hooks/incoming-webhook?token=' . $webhook_token;
$show_name = c::get('show_name');
$botname = c::get('botname');
$translate = c::get('translate');
$giphy_api_key = c::get('giphy_api_key');

$term = str_replace(' ', '-', $text);
$giphy_endpoint = 'http://api.giphy.com/v1/gifs/random?api_key=' . $giphy_api_key; // Default to getting a random gif
$url = '';

// If there's a search term, use one of the search API's
if (!empty($term)) {
	// Use Giphy's Translation API
	if ($translate) {
		$giphy_endpoint = 'http://api.giphy.com/v1/gifs/translate?api_key=' . $giphy_api_key . '&s=';
	}
	// Use Giphy's Search API
	else {
		$giphy_endpoint = 'http://api.giphy.com/v1/gifs/search?limit=25&api_key=' . $giphy_api_key . '&q=';
	}
}

$giphy_json = json_decode(file_get_contents($giphy_endpoint.$term));
$giphy_data = $giphy_json->data;

if (!count($giphy_data)) {
	echo "No gifs for " . $term;
	return;
}
else if (empty($term)) {
	$url = $giphy_data->image_original_url;
}
else {
	if (is_array($giphy_data)) {
		$url = $giphy_data[array_rand($giphy_data)]->images->original->url;	
	}
	else {
		$url = $giphy_data->images->original->url;		
	}
}

header("HTTP/1.1 200 OK");
$json = array(
	        'payload' => json_encode(array(
	        	'unfurl_links' => true,
	        	'text' => '<' . $url . '|' . (!empty($text) ? $text : '') . '>',
	        	'channel' => !empty($channel_name) ? '#' . $channel_name : null,
	        	'username' => $botname . ($show_name && !empty($user_name) ? ' :: ' . $user_name : '')
	        ))
	    );

// If no slack request token, just render out the gif result to the page
if (empty(r::get('token'))) {
	echo '<img src="' . $url . '" />';
}
// Integrate with Slack's incoming webhooks
else {
	// Get cURL resource
	$curl = curl_init();
	// Set some options - we are passing in a useragent too here

	curl_setopt_array($curl, array(
	    CURLOPT_URL => $room_url,
	    CURLOPT_POST => 1,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POSTFIELDS => $json
	));

	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	// Close request to clear up some resources
	curl_close($curl);
}