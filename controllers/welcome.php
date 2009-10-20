<?php

class Welcome extends Controller {

    function __construct() {
    	parent::Controller();
    	
        $this->load->library('rest', array(
        	'server' => 'http://localhost/classes/restserver/index.php/example_api/',
        	'http_auth' => 'digest',
        	'http_user' => 'admin',
        	'http_pass' => '1234'
        ));

		$this->load->helper(array('url', 'form'));

    }

	function index()
	{
		$this->load->view('welcome_message');
	}
    
    function view_user($id = 0)
    {
        $responce = $this->rest->get('user/id/'.$id, array(
        	'name'=>'Some dude', 'email' => 'dudeface.magee@gmail.com'
		));
		
        echo "<pre>";
        print_r($responce);
        echo "</pre>";
        
        echo $this->rest->debug();
    }
    
    function new_user()
    {
        $responce = $this->rest->put('user/id/25', array(
			'name'=>'New guy!', 'email' => 'dudeface.magee@gmail.com', 'status' => 'ADDED!')
		);
		
        echo "<pre>";
        print_r($responce);
        echo "</pre>";
        
        echo $this->rest->debug();
    }
    
    function delete_user($id = 0)
    {
        $responce = $this->rest->delete('user/id/23');
        
        echo "<pre>";
        print_r($responce);
        echo "</pre>";
        
        echo $this->rest->debug();
    }
    
}

?>