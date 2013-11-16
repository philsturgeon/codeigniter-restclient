# CodeIgniter-REST Client

CodeIgniter-REST Client is a CodeIgniter library which makes it easy to do use REST services/API's such as Twitter, Facebook and Flickr, whether they are public or hidden behind HTTP Basic/Digest.  The examples below are VERY simple ones and more can much more can be done with it. 

Please take a look at the code to see about things like api_key() and other post/put/delete methods.

## Requirements

1. PHP 5.1+
2. CodeIgniter 2.0.0+
3. cURL
4. CodeIgniter Curl library: http://getsparks.org/packages/curl/show

## Usage

	// Load the rest client spark
	$this->load->spark('restclient/2.1.0');

	// Load the library
	$this->load->library('rest');

	// Run some setup
	$this->rest->initialize(array('server' => 'http://twitter.com/'));

	// Pull in an array of tweets
	$tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

## Usage (with API Key)

	// Load the rest client spark
	$this->load->spark('restclient/2.1.0');

	// Load the library
	$this->load->library('rest');

	// Run some setup
	$this->rest->initialize(array('server' => 'http://twitter.com/'));

	// Set your API Key
	// By default, it assumes that the header is: X-API-KEY (which matches the REST Server)
	$this->rest->api_key('YOUR_API_KEY');

	// Pull in an array of tweets
	$tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

## Acknowledgements

CodeIgniter Rest Client was origionally written by the awesome Phil Sturgeon, The following people have contributed to this project:

Chris Kacerguis (https://github.com/kitsched)
vlakoff (https://github.com/vlakoff)
Steven Bullen (https://github.com/StevenBullen)
rhbecker (https://github.com/rhbecker)
János Rusiczki (https://github.com/kitsched)

