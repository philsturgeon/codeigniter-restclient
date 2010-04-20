<?php
class Test extends Controller
{
    function index()
    {
        $this->load->helper(array('url', 'form'));
        
        $data = array();
        
        if($this->input->post('server'))
        {
        	$this->load->library('rest', array(
	        	'server' => $this->input->post('server')
	        ));
	        
	        $method = trim($this->input->post('method', TRUE));
	        $uri = trim($this->input->post('uri', TRUE));
	        $format = trim($this->input->post('format', TRUE));
	        $params = unserialize(trim($this->input->post('params', TRUE)));
        
	        $this->rest->format($format);
	        
			if(in_array($method, array('put', 'post')))
			{	        
				$result = $this->rest->{$method}($uri, $params);
			}
			elseif(in_array($method, array('get', 'delete')))
			{	        
				$result = $this->rest->{$method}($uri);
			}
			
			$this->load->view('test_form', array('result' => $result, 'debug' => $this->rest->debug()));
			
        }
        
        else
        {
        	$this->load->view('test_form', array('result' => '', 'debug' => ''));
        }
        

    }
    
    
}

?>