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
			$params = $this->input->post('params', TRUE);

	        $this->rest->format($format);
	        $this->rest->api_key('foo');
	        $this->rest->language('en-GB, pr');

//			parse_str($params, $params);
//
//			$params['preview_file'] = 'FOO';//file_get_contents('/Users/phil/Desktop/Files/AstralSpica.jpg');
//			$params['preview_file_ext'] = 'jpg';
//
//			var_dump($params);

			if(in_array($method, array('put', 'post', 'get', 'delete')))
			{
				$result = $this->rest->{$method}($uri, $params);
			}
			
			$this->load->view('test_form', array('result' => $result, 'debug' => $this->rest->debug()));
			
        }
        
        else
        {
        	$this->load->view('test_form', array('result' => '', 'debug' => ''));
        }
    }
}