<html>
<head>
<title>Welcome to CodeIgniter REST Client</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<div style="position:fixed; width:100%; top:0; left:0; background-color:lightgrey; padding-left:2em">
	
	<?php echo form_open( $this->uri->uri_string() ); ?>
	
	<p style="width:25em; float:left"><label>Server (tail slash):</label> <?php echo form_input('server', $this->input->post('server')); ?></p>
	<p style="width:35em; float:left"><label>URI (Resource) - no preceeding slash:</label> <?php echo form_input('uri', $this->input->post('uri')); ?></p>
	<p style="width:35em; float:left"><label>Params (as a query string): </label><?php echo form_input('params', $this->input->post('params')); ?></p>
	<br style="clear:both" />
	<p style="width:20em; float:left"><label>Method:</label> <?php echo form_dropdown('method', array('get'=>'GET', 'post' => 'POST', 'put' => 'PUT', 'delete' =>'DELETE'), $this->input->post('method')); ?></p>
	<p style="width:35em; float:left"><label>Request format:</label> <?php echo form_dropdown('format', array('xml'=>'xml', 'json'=>'json', 'csv'=>'csv', 'html'=>'html', 'serialize'=>'serialize'), $this->input->post('format')); ?></p>
	
	<p><?php echo form_submit('go', 'Make Request'); ?></p>
	
	<?php echo form_close(); ?>
</div>

<div style="margin-top:9em;">
<?php echo $debug; ?>
</div>

<?php if(!empty($result)): ?>
<h2>PHP Result</h2>

<p>A useable PHP array or object for use in your code.</p>

<pre>
<?php var_dump($result); ?>
</pre>

<?php else: ?>

<p>Try entering "http://twitter.com/" as the server and "users/show/philsturgeon" as the Resource. Then fiddle with format to see what the Twitter API does.</p>

<?php endif; ?>

<p><br />Page rendered in {elapsed_time} seconds</p>

</body>
</html>