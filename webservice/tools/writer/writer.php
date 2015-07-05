<?php

namespace tools\writer;

require_once('tools/object/tool.php');
require_once('tools/validation/validator.php');
require_once('tools/validation/enforcer.php');
require_once('tools/constants/constants.php');
require_once('tools/constants/limits.php');

use tools\constants\Tool as Tool;
use tools\constants\Constants as Constants;
use tools\constants\Limits as Limits;

//require_once('tools/constants/config.php');
//require_once('tools/constants/limits.php');
//require_once('tools/writer/logger.php');
//use tools\constants\Config as Config;
//use tools\constants\Limits as Limits;
//use tools\writer\Logger as Logger;

/** tools/writer/writer.php 
 * prints the requested data into either json or xml format based on the request
 */
class Writer {
		
	/* prints the requested data (error or normal) and return the response as per http status code
	 * $http_status_code accepted are defined in tools/constants/constants.php - $http_status_codes
	 * $data are accepted in either simple text eg. 'error message goes here' or in an array where it contains the return results
	 * $parent_tag can be in any text form, however if the $parent_tag used is the reserved $error_tag defined in tools/constants/constants.php, it will print as an error
	 * $return_type accepted are defined in tools/constants/constants.php - $allowed_return_types
	 */
	public static function write($http_status_code, $data, $parent_tag, $return_type = 'json') {
		
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
	
		//setting default values to the input parameters
		$http_status_code = set_default($http_status_code, 200); $data = set_default($data, array());
		$parent_tag = set_default($parent_tag, 'datas'); $return_type = set_default($return_type, Constants::get('default_return_type'));
		
		//retrieve required limits from tools/constants/limits
		$text_limit = Limits::get('text_limit');
	
		//ensuring that inputs are validated against the array list of requirements $enforcement contains the results of the validation and message of the error if any.
		$enforcement = enforce_inputs(array($data, 'string:array', null, null, false),
									  array($parent_tag, 'string', $text_limit['min'], $text_limit['max'], false),
									  array($return_type, 'string', Constants::get('allowed_return_types'), null, false));
		
		$http_status_codes = Constants::get('http_status_codes');
		if(isset($http_status_codes[$http_status_code])) { //validates if the $http_status_code provided is in the list
			if(compare_string($parent_tag, Constants::get('error_tag'))) { //checks if the write request is for an error or a result printout
				
				//$data = array('http_status_code'=>$http_status_code, 'http_status_message'=>$http_status_codes[$http_status_code], 'message'=>$message);
				//if($details != '' && Config::get('enable_debugging') == true) { $data['details'] = $details; }
							
			} else { if(!is_array($data)) { Writer::write(400, 'Data provided must be an array.', Constants::get('error_tag'), $return_type); return; } }
			
			//formats the data return with the appropriate http status code.
			header('HTTP/1.0 ' . $http_status_code . ' ' . $http_status_codes[$http_status_code], true, $http_status_code);
			
			if(compare_string($return_type, Constants::get('xml'))) { //checks if the user requested data to be returned in xml (by default json)
				header('Content-type: text/xml');
				echo '<' . $parent_tag . '>';
    			foreach($data as $index => $post) {
      				if(is_array($post)) {
        				foreach($post as $key => $value) {
          					echo '<',$key,'>';  if(is_array($value)) { foreach($value as $tag => $val) { echo '<',$tag,'>',htmlentities($val),'</',$tag,'>'; } } echo '</',$key,'>';
        				}
      				} else { echo '<' . $index . '>' . $post . '</' . $index . '>'; }
    			}
				echo '</' . $parent_tag . '>';
		
			} else {
				//header('Content-type: application/json; charset=UTF-8');
    			echo json_encode(array($parent_tag=>$data));
			}
				
		} else { Writer::write(400, 'Invalid HTTP status code.', Constants::get('error_tag'), $return_type); return; } 
	}
}

?>