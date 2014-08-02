<?php
$term = isset($_GET['text']) ? str_replace(" ", "-", $_GET['text']) : '';
$giphy_endpoint = isset($term) && $term != '' ? 'http://api.giphy.com/v1/gifs/translate?limit=10&api_key=dc6zaTOxFJmzC&s=' : 'http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC';

if (isset($term) && $term != '') {
	if ($translate) {
		// echo 'Used translation API';
		$giphy_endpoint = 'http://api.giphy.com/v1/gifs/translate?api_key=dc6zaTOxFJmzC&s=';
	}
	else {
		// echo 'Used search API';
		$giphy_endpoint = 'http://api.giphy.com/v1/gifs/search?limit=25&api_key=dc6zaTOxFJmzC&q=';
	}
}
else {
	// echo 'Used random gif API';
	$giphy_endpoint = 'http://api.giphy.com/v1/gifs/random?api_key=dc6zaTOxFJmzC';
}

$user_name = $use_name && isset($_GET['user_name']) ? $_GET['user_name'] : '';
$giphy_json = json_decode(file_get_contents($giphy_endpoint.$term));

$giphy_data = $giphy_json->data;
$url = '';

if (!count($giphy_data)) {
	echo "No gifs for " . $term;
	return;
}
else if (!isset($term) || $term == '') {
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
	        	'text' => '<'.$url . '|' . (isset($_GET['text']) ? $_GET['text'] : '') . '>',
	        	'channel' => isset($_GET['channel_name']) ? '#'.$_GET['channel_name'] : null,
	        	'group' => isset($_GET['group_name']) ? $_GET['group_name'] : null,
	        	'username' => 'gifbot :: '.$user_name
	        ))
	    );

if (!isset($_GET['token'])) {
	echo '<img src="'.$url.'" />';	
}
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
?>