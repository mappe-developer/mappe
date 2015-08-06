<?php

/* -- tools/validation/enforcer.php --
 * contains reusable shorthand enforcing functions 
 * ## declare on the GLOBAL namespace ##
 */

/* required dependencies */ 
require_once('tools/object/tool.php');
require_once('tools/constants/constants.php');
require_once('tools/constants/config.php');
require_once('tools/validation/validator.php');
require_once('tools/writer/writer.php');

use tools\object\Tool as Tool;
use tools\constants\Constants as Constants;
use tools\constants\Config as Config;
use tools\writer\Writer as Writer;

/* Takes in an array of arrays containing the variable inputs and their requirements. Error will be thrown if requirements are not met. 
 * It takes in a variable list of variables, but requiring every variable to be an array of requirements.
 * The last parameter it takes is maybe a boolean ($simple) or omitted, if present, it will alter the returned results.
 * The list of array validation requirement format is as follow - [variable, type, min, max, nullable*]
 * However, the min, max can be replaced by an array list in either with the other as null, it will be able to validate if it exist in the list passed in.
*/
function enforce_inputs() {
	
	$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);

	$message = ''; $variable = ''; $line = '';
	
	//retrieve last item as return type if available
	$array = func_get_args(); $return_type = end($array);
	if(is_string($return_type) == false) {  $return_type = Constants::get('default_return_type'); }
	else { 
		$allowed_return_types = Constants::get('allowed_return_types');
		if(array_contains($return_type, $allowed_return_types) == false) { $return_type = Constants::get('default_return_type'); }
	}
	
	//loop through every item to validate, sets a message to throw the error at the end of the method
	foreach($array as $list) {
		if(is_ready($list)) { //every list must be ready
			if(is_array($list)) { //ensure that item is an array
				if(count($list) == 5) { //every list contains the required items
					
					$variable = set_default($list[0], null); $type = set_default($list[1], ':'); 
					$min = set_default($list[2], null); $max = set_default($list[3], null); $nullable = set_default($list[4], false); $validation_list = null;
					
					if(isset($variable)) { //ensure that variable is set
						
						//ensures that valid variable list type is request
						if(list_contains($type, Constants::get('variable_list')) == false) { $message = 'Invalid variable validation requirement - type (' . $type . ') unrecognized.'; $line = __LINE__; }
						//if either one is not a numeric, check for array
						if(validate_type($min, 'numeric') == false || validate_type($max, 'numeric') == false) {
							if(validate_type($min, 'array') == true || validate_type($max, 'array') == true) {
								$validation_list = ((is_null($min) == true || isset($min) == false) && validate_type($max, 'array')) ? $max : $min;
								if(validate_type($validation_list, 'array') == false) {  $message = 'Invalid variable validation requirement - an array to validate is required.'; $line = __LINE__; }	
							} else if(is_null($min) == false || is_null($max) == false) { 
								$message = 'Invalid variable validation requirement - min/max must be numeric or an array of list in either one or both nulls.'; $line = __LINE__; 
							}
						//ensure than max is less than min
						} else if ($max < $min) { $message = 'Invalid variable validation requirement - min is more than max.'; $line = __LINE__; }
						//ensure that nullable is boolean
						if(validate_type($nullable, 'bool') == false) { $message = 'Invalid variable validation requirement - nullable must be boolean.'; $line = __LINE__; }
						
						//verify variable if not null
						if(!is_null($variable)) {	
								if(validate_type($variable, $type) == false) { $message = 'Variable is not a ' . $type . '.'; $line = __LINE__; } 
								if(is_null($validation_list) == false && isset($validation_list) == true) {
									if(array_contains($variable, $validation_list) == false) { $message = 'Variable is not found in the list provided.'; $line = __LINE__; }
								} else if(validate_type($variable, 'string:numeric') == true) {
									if(is_null($min) == false || is_null($max) == false) {
										if(validate_range($variable, $min, $max) == false) { $message = 'Variable does not meet the min/max requirement.'; $line = __LINE__; }
									} 
								}
						}
							
					} else if ($nullable == false) { $message = 'Variable is not set, unable to validate variable'; $line = __LINE__; }
			
				} else { $message = 'Incomplete variable validation list. [variable, type, min, max, nullable*]'; $line = __LINE__; }
			} 
		} else { $message = 'Invalid variable validation list, an array is required. [variable, type, min, max, nullable*]'; $line = __LINE__; }
	}

	if(compare_string($message, '') == false) { 
		$variable_name = variable_name($variable);
		if(isset($variable_name) == true && $variable_name != '') { $variable_name = '$' . $variable_name; } else { $variable_name = ($type != 'password') ? $variable : '*password*'; }
		if($variable_name != '') { $variable_name = ' [' . $variable_name . ']'; } 
		
		$error = Tool::prepare(($message . $variable_name), '', $line, $return_type, Constants::get('default_error_code'));
		Tool::error($function, $error, false);
	}
	
}

//ensure that the request is sent with https, else error will be thrown
function enforce_https($return_type = 'json') {
	$enable_https = Config::get('enable_https');
	if($enable_https == true) {
		if(validate_https() == false) { Writer::write(412, 'Request is not sent securely with https.', Constants::get('error_tag'), $return_type); }
		else { return true; }
	}
}
	
?>