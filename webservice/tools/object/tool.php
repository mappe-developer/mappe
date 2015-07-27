<?php

namespace tools\object;

require_once('tools/validation/validator.php');
require_once('tools/constants/config.php');
require_once('tools/constants/constants.php');
require_once('tools/writer/writer.php');

use tools\constants\Config as Config;
use tools\constants\Constants as Constants;
use tools\writer\Writer as Writer;

/** tools/object/tool.php 
 * contains quickhand methods that all tools will require
 */
class Tool {
	
	public static function prepare($message, $details, $line, $return_type, $http_status_code = 400) {
		$return_type = set_default($return_type, Constants::get('default_return_type'));
		return array('http_status_code'=>$http_status_code, 'message'=>$message, 'details'=>$details, 'line'=>$line, 'return_type'=>$return_type);
	}
	
	/*prepares and prints the error, writes to log if indicated */
	public static function error($info, $error, $loggable = false) {
		
		//preset $info('class_name', 'method_name', 'return_type')
		$class_name = set_default($info['class_name'], '');
		$method_name = set_default($info['method_name'], '');
		$return_type = set_default($error['return_type'], Constants::get('default_return_type'));
		
		//preset $error('message', 'details', 'line', 'error_code')
		$message = set_default($error['message'], 'Unknown Error Occurred.'); $details = set_default($error['details'], '');
		$line = set_default($error['line'], ''); $http_status_code = set_default($error['http_status_code'], Constants::get('default_error_code'));
		
		$error['function'] = str_replace($class_name . '/', '', $method_name);
		Writer::write($http_status_code, $error, Constants::get('error_tag'), $return_type);
		
		$debuggable = Config::get('enable_debugging');
		if($debuggable == true) {
		
		}
		
		if($loggable == true) { 
			
		
		} //write to log 
		exit;
	}
}	

?>