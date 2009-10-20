<?php
class Twitter extends Controller {

    function __construct()
    {
    	parent::Controller();
    	
        $this->load->library('rest', array(
        	'server' => 'http://twitter.com/'
        ));

    }

    function show_user($username = '')
    {
    	if(!$username)
    	{
    		show_error('Please enter a user in the title. Eg: '.anchor('twitter/show_users/philsturgeon', 'twitter/show_users/philsturgeon'));
    	}
    	
        $result = $this->rest->get('users/show/'.$username);
        
        foreach( $result as $thing => $value )
        {
        	echo '<strong>'.$thing.':</strong> '.$value.'<br/>';
        }

    }
    
    function tweets($username = '')
    {
    	if(!$username)
    	{
    		show_error('Please enter a user in the title. Eg: '.anchor('twitter/tweets/philsturgeon', 'twitter/tweets/philsturgeon'));
    	}
    	
        $result = $this->rest->get('statuses/user_timeline/'.$username.'.xml');
        
        echo $this->rest->debug();

    }
    
    
}

?>