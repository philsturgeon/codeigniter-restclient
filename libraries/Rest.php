<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author Philip Sturgeon
 * @created 04/06/2009
 */

class REST {
	
    private $CI;                // CodeIgniter instance

    private $rest_server;
    
    private $supported_formats = array(
		'xml' 				=> 'application/xml',
		'json' 				=> 'application/json',
		'serialize' 		=> 'text/plain',
		'php' 				=> 'text/plain',
	);
    
    private $auto_detect_formats = array(
		'application/xml' 	=> 'xml',
		'text/xml' 			=> 'xml',
		'application/json' 	=> 'json',
		'text/json' 		=> 'json',
		'text/csv' 			=> 'csv',
		'application/csv' 	=> 'csv'
	);
	
	private $format;
	private $mime_type;
    
    private $responce_string;
    
    function __construct($config = array())
    {
        $this->CI =& get_instance();
        log_message('debug', 'REST Class Initialized');
        
		$this->CI->load->library('curl');
		
		// If a URL was passed to the library
		if(!empty($config))
		{
			$this->initialize($config);
		}
    }
    
    public function initialize($config)
    {
		$this->rest_server = @$config['server'];
		
		if(substr($this->rest_server, -1, 1) != '/')
		{
			$this->rest_server .= '/';
		}
		
		$this->http_auth = isset($config['http_auth']) ? $config['http_auth'] : '';
		$this->http_user = isset($config['http_user']) ? $config['http_user'] : '';
		$this->http_pass = isset($config['http_pass']) ? $config['http_pass'] : '';
    }

    
    public function get($uri, $params = array(), $format = NULL)
    {
        if(!empty($params))
        {
        	$uri .= '?'.http_build_query($params);
        }
    	
    	return $this->_call('get', $uri, NULL, $format);
    }
    
    
    public function post($uri, $params = array(), $format = NULL)
    {
        return $this->_call('post', $uri, $params, $format);
    }
    
    
    public function put($uri, $params = array(), $format = NULL)
    {
        return $this->_call('put', $uri, $params, $format);
    }
    
    
    public function delete($uri, $format = NULL)
    {
        return $this->_call('delete', $uri, NULL, $format);
    }
    
    
    private function _call($method = 'get', $uri, $params = array(), $format = NULL)
    {
    	if($format !== NULL)
		{
			$this->format($format);
		}

		$this->_set_headers();
        
        // Initialize cURL session
        $this->CI->curl->create($this->rest_server.$uri);
        
        // If authentication is enabled use it
        if($this->http_auth != '' && $this->http_user != '')
        {
        	$this->CI->curl->http_login($this->http_user, $this->http_pass, $this->http_auth);
        }
        
        // Run and send params if its post or put
        if($method == 'post' || $method == 'put')
        {
	        $this->CI->curl->$method($params);
    	}
    	
    	// Run without params if its delete
    	elseif($method == 'delete')
    	{
	        $this->CI->curl->$method();
    	}
        
        $responce = $this->CI->curl->execute();

        // Format and return
        return $this->_format_responce($responce);
    }
    
    
    // If a type is passed in that is not supported, use it as a mime type
    public function format($format)
	{
		if(array_key_exists($format, $this->supported_formats))
		{
			$this->format = $format;
			$this->mime_type = $this->supported_formats[$format];
		}
		
		else
		{
			$this->mime_type = $format;
		}
						 
		return $this;
	}
	
	public function debug()
	{
		$request = $this->CI->curl->debug_request();
		
		echo "=============================================<br/>\n";
		echo "<h2>REST Test</h2>\n";
		echo "=============================================<br/>\n";
		echo "<h3>Request</h3>\n";
		echo $request['url']."<br/>\n";
		echo "=============================================<br/>\n";
		echo "<h3>Responce</h3>\n";
		
		if($this->responce_string)
		{
			echo "<code>".nl2br(htmlentities($this->responce_string))."</code><br/>\n\n";
		}
		
		else
		{
			echo "No responce<br/>\n\n";
		}
		
		echo "=============================================<br/>\n";
		
		if($this->CI->curl->error_string)
		{
			echo "<h3>Errors</h3>";
			echo "<strong>Code:</strong> ".$this->CI->curl->error_code."<br/>\n";
			echo "<strong>Message:</strong> ".$this->CI->curl->error_string."<br/>\n";
			echo "=============================================<br/>\n";
		}
		
		echo "<h3>Call details</h3>";
		echo "<pre>";
		print_r($this->CI->curl->info);
		echo "</pre>";
		
	}
	
	
	private function _set_headers()
	{
		$this->CI->curl->http_header('Accept: '.$this->mime_type);
	}
	
	private function _format_responce($responce)
	{
		$this->responce_string =& $responce;
		
		// It is a supported format, so just run its formatting method
		if(array_key_exists($this->format, $this->supported_formats))
		{
			return $this->{"_".$this->format}($responce);
		}

		// Find out what format the data was returned in
		$returned_mime = @$this->CI->curl->info['content_type'];
		
		// If they sent through more than just mime, stip it off
		if(strpos($returned_mime, ';'))
		{
			list($returned_mime)=explode(';', $returned_mime);
		}
		
		$returned_mime = trim($returned_mime);
		
		if(array_key_exists($returned_mime, $this->auto_detect_formats))
		{
			return $this->{"_".$this->auto_detect_formats[$returned_mime]}($responce);
		}
		
		return $responce;
	}
	
	
    // Format XML for output
    private function _xml($string)
    {
    	return (array) simplexml_load_string($string);
    }
    
    // Format HTML for output
    // This function is DODGY! Not perfect CSV support but works with my REST_Controller
    private function _csv($string)
    {
		$data = array();
		
		// Splits
		$rows = explode("\n", trim($string));
		$headings = explode(',', array_shift($rows));
		foreach( $rows as $row )
		{
			// The substr removes " from start and end
			$data_fields = explode('","', trim(substr($row, 1, -1)));
			
			if(count($data_fields) == count($headings))
			{
				$data[] = array_combine($headings, $data_fields);
			}
			
		}
		
		return $data;
    }
    
    // Encode as JSON
    private function _json($string)
    {
    	return json_decode(trim($string));
    }
    
    // Encode as Serialized array
    private function _serialize($string)
    {
    	return unserialize(trim($string));
    }
    
    // Encode raw PHP
    private function _php($string)
    {
    	$string = trim($string);
    	$populated = array();
    	eval("\$populated = \"$string\";");
    	return $populated;
    }
    
}
// END REST Class

/* End of file REST.php */
/* Location: ./application/libraries/REST.php */
?>