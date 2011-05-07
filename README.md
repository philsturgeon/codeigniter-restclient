# CodeIgniter-REST Client

CodeIgniter-REST Client is a CodeIgniter library which makes it easy to do use REST services/API's such as Twitter, Facebook and Flickr, wether they are public or hidden behind HTTP Basic/Digest.

## Requirements

1. PHP 5.1+
2. CodeIgniter 2.0.0+
3. cURL
4. CodeIgniter Curl library: http://getsparks.org/packages/curl/show

## Usage

	// Load the rest client spark
	$this->load->spark('restclient');
	
	// Run some setup
	$this->rest->initialize(array('server' => 'http://twitter.com/'));
    
	// Pull in an array of tweets
    $tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

This is clearly a VERY simple example and more can much more can be done with it. For up-to-date 
documentation keep an eye on the following link:

http://philsturgeon.co.uk/restclient/