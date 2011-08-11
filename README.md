# CodeIgniter-REST Client

CodeIgniter-REST Client is a CodeIgniter library which makes it easy to do use REST services/API's such as Twitter, Facebook and Flickr, wether they are public or hidden behind HTTP Basic/Digest.

## Requirements

1. PHP 5.1+
2. CodeIgniter 2.0.0+
3. cURL
4. CodeIgniter Curl library: http://getsparks.org/packages/curl/show

## Usage

	// Load the rest client spark
	$this->load->spark('restclient/2.0.0');

	// load the rest library
	$this->load->library('rest');
	
	// Run some setup
	$this->rest->initialize(array('server' => 'http://twitter.com/'));

	// for ssl and http basic authentication initialize with:
	$this->rest->initialize(array('server' => 'https://example.com/',
								  'http_user' => 'username',
								  'http_pass' => 'password',
								  'http_auth' => 'basic',
								  'ssl_verify_peer' => TRUE,
								  'ssl_cainfo' => '/certs/cert.pem'));
    
	// Pull in an array of tweets
    $tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

This is clearly a VERY simple example and more can much more can be done with it. Take a look at the code to see about things like api_key() and other post/put/delete methods.