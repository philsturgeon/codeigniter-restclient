CodeIgniter-REST Client
================

CodeIgniter-REST Client is a CodeIgniter library which makes it easy to do use REST services/API's such as Twitter, Facebook and Flickr, wether they are public or hidden behind HTTP Basic/Digest.


Requirements
------------

1. PHP 5.1+
2. CodeIgniter 1.6.x - 2.0-dev
3. cURL
4. CodeIgniter Curl library: http://github.com/philsturgeon/codeigniter-curl

Usage
-----

	$this->load->library('rest', array(
       	'server' => 'http://twitter.com/'
  	));
        
    $tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

This is clearly a VERY simple example and more can much more can be done with it. For up-to-date 
documentation keep an eye on the following link:

http://philsturgeon.co.uk/restclient/