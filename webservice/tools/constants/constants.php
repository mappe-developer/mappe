<?php

namespace tools\constants;

/* tools/contants/constants.php 
 * contains the common constants shared accross the different exposed services in the server.
 */
 
class Constants {
	
	//general constants
	private static $allowed_http_methods = array('GET', 'POST', 'PUT', 'DELETE');
	private static $allowed_return_types = array('xml', 'json');
	private static $default_http_method = 'GET';
	
	private static $http_status_codes = array(  
        	100 => 'Continue', 101 => 'Switching Protocols',  
           	200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 
			204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content',  
            300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified',  
            305 => 'Use Proxy', 306 => '(Unused)', 307 => 'Temporary Redirect',  
            400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found',  
            405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Timeout',
	 		409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long', 415 => 'Unsupported Media Type', 416 => 'Requested Range Not Satisfiable', 417 => 'Expectation Failed',  
            500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable',  
            504 => 'Gateway Timeout', 505 => 'HTTP Version Not Supported');
	
	private static $error_tag = 'error';
	private static $default_error_code = 400;
	
	private static $xml = 'xml';
	private static $json = 'json';
	private static $default_return_type = 'json';
	
	private static $default_file_type = 'php';
	private static $allowed_file_types = array('php', 'html', 'htm');
	private static $variable_list = array('array', 'bool', 'boolean', 'float', 'int', 'null', 'numeric', 'object', 'resource', 'scalar', 'string', 'password');
	
	//path location
	private static $controller_location = '/access/controller';
	private static $controller_reference = '\\access\\controller';
	
	//logging constants
	private static $default_logging_level = 'info';
	private static $logging_levels = array('e' => 'error', 'w' => 'warning', 'i' => 'info', 'd' => 'debug', 'v' => 'verbose', 'wtf', 'wtf');
	
	//hashing and security constants
	private static $allowed_hash_types = array('MD5'); //allow hash types would require to corresponding hash regex in the /tools/constants/constants file
	
	//access method
	public static function get($key) { return self::$$key; }
}

?>