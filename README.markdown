CodeIgniter-REST Client
================

CodeIgniter-REST Client is a CodeIgniter library which makes it easy to do use REST services/API's such as Twitter, Facebook and Flickr, wether they are public or hidden behind HTTP Basic/Digest.

Usage
-----

	$this->load->library('rest', array(
       	'server' => 'http://twitter.com/'
  	));
        
    $tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');

This is clearly a VERY simple example and more can much more can be done with it. For up-to-date 
documentation keep an eye on the following link:

http://philsturgeon.co.uk/restclient/

Requirements
------------

CodeIgniter... duh
CodeIgniter Curl library: http://github.com/philsturgeon/codeigniter-curl

Extra
-----

If you'd like to request changes, report bug fixes, or contact
the developer of this library, email <email@philsturgeon.co.uk>