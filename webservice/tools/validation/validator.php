<?php

/* -- tools/validation/validator.php --
 * contains reusable shorthand functions 
 * ## declare on the GLOBAL namespace ##
 */
 
/* required dependencies */
require_once ('tools/constants/constants.php'); 
require_once ('tools/constants/regex.php'); 
use tools\constants\Constants as Constants;
use tools\constants\Regex as Regex; 

/****** Variable Validation Functions ******/

/* takes in an input by reference and check if it isset, is_null, or is an empty string
 * if variable isset, not null and is not an empty string, returns true, otherwise returns false
 */
function is_ready($variable = null) {
	$results = false;
	if(isset($variable) == true && is_null($variable) == false) { //if variable isset with a value and value is not null.
		$results = true; if(is_string($variable)) { if(trim($variable) === '') { $results = false; } } //if variable is string, check if string is empty.
	} 
	return $results; //returns (boolean) true or false
}

/* takes in the user input, returns the trimmed and escaped user input.
   @$string_input will process strings or an array of strings
   original value of the variable will be returned if it is unable to trim or/and escape the input. */
function sanitize_input($string_input) {
	if(isset($string_input)) {
		if(is_string($string_input)) { $string_input = trim($string_input); }
		else if(is_array($string_input)) { foreach($string_input as $string) { if(is_string($string)) { $string = trim($string); } } }
	}
	return $string_input;
}

/* checks if the variable is unset, null or empty and assign the default value 
 * if the variable is unset, null or empty (if string), the default value will be set to the variable. 
 * $variable will not be able to take in a value for eg. is_ready('abc');, a variable has to be used, eg. $x; is_ready($x);
 */
function set_default(&$variable, $default) { 
	if(is_ready($variable) == false) { $variable = sanitize_input($default); }
	return $variable; //returns the selected variable
}

/* Rewrite method of in_array to check if the array contains the item. However, it sanitizes the input before checking */
function array_contains($item, $allowed_array, $case_sensitive = false) {
	$results = false;
	if(isset($item) == true && is_array($allowed_array)) { 
		$item = sanitize_input($item);
		if(is_string($item) && $case_sensitive == false) { if(in_array(strtoupper($item), $allowed_array) || in_array(strtolower($item), $allowed_array)) { $results = true; } }
		else { if(in_array($item, $allowed_array)) { $results = true; } }
	}
	return $results;
}


/****** String Manipulation *******/

/* rewrite method of strcmp which sanitizes and trim inputs, including case sensitive comparision */
function compare_string($input_one = '', $input_two = '', $case_sensitive = false) {
	if($case_sensitive == false) { $input_one = sanitize_input(strtolower($input_one)); $input_two = sanitize_input(strtolower($input_two)); }
	return strcmp($input_one, $input_two) == 0 ? true : false;
}

/* takes in a string list of items separated by the ':', it matches it against an array to check if the item exist in the array
   function is similar to array_contains/in_array however it allows multiple items to be validated at the same time
   @$greedy is a boolean value, when set to true, all items set to validate against the list must match
   if @$greedy is set to false, as long as any item matches, true is returned
*/
function list_contains($items, $list, $greedy = true) {
	$items = explode(':', $items); $count = count($items);
	foreach($list as $list_item) {
		foreach($items as $item) {
			if($list_item == $item) { $count -= 1; }
		}
	}
	
	$results = false;
	if($greedy == true) { if($count == 0) { $results = true; } else { $results = false; } }
	else { if($count == count($items)) { $results = false; } else if ($count < count($items)) { $results = true; } }
	
	return $results;
}

/* takes in a string list of items separated by the ':', it matches it against an array keys to check if the item exist in the array
   function is checks if the keys exists in the array, list given must be an associative array (else return false)
   @$greedy is a boolean value, when set to true, all items set to validate against the list must match
   if @$greedy is set to false, as long as any item matches, true is returned
*/
function list_contains_keys($items, $list, $greedy = true) {
	$items = explode(':', $items); $count = count($list);
	if($count === 0) { $count = 1000; } //if original list is empty, set to a random number
	while(list($key, $value) = each($list)) {
		foreach($items as $item) {
			if($key == $item) { $count -= 1; }
		}
	}

	$results = false;
	if(is_associative($list)) { 
		if($greedy == true) { if($count == 0) { $results = true; } else { $results = false; } }
		else { if($count < count($list)) { $results = true; } }
	}	
	return $results;
}

/* Takes in the array to check whether array is associative. Returns true if it is associative else return false if it is index */
function is_associative($array) {
	 return array_keys($array) !== range(0, count($array) - 1);
}

/****** To Type Validation *******/

/* checks if the variable passed in is within the allow list of variable types (tools/constants/constants.php). List seperated by ":" 
   takes in additional parameter to ensure that password is string
   variable list can be as individual eg. 'string' or 'string:numeric', if any falls into the allowed list, it would be accepted
*/
function validate_type($variable, $allowed_list, $greedy = false) {
	$results = false; 
	$allowed_list = explode(':', $allowed_list); $count = count($allowed_list);
	foreach($allowed_list as $variable_type) {
		if($variable_type == 'password') { $variable_type = 'string'; } 
		$callable_function = 'is_' . sanitize_input($variable_type);
		if(function_exists($callable_function)) { if(call_user_func($callable_function, $variable) || $results == true) { $results = true; $count -= 1; } }
		if($greedy) { if($count != 0) { $results = false; }}
	}		
	return $results;
}

/* checks if the variable length/value falls within the minimum/maximum range provided 
   method validates both string and numeric values 
   if string is provided, string's length is matched
   if numeric is provided, the value of the numeric is matched
   true is returned whenever the matched value is equals to the min/max, more than equals to min, or lesser than equals to max
   if any other cases false is returned.
*/
function validate_range($variable, $min, $max) { 
	$results = false;
	if(is_null($variable) == false && isset($variable) == true) { 
		if(validate_type($min, 'numeric:string:null') == true && validate_type($max, 'numeric:string:null') == true) {
			if(is_numeric($variable)) {	
				if((is_null($min) == false && isset($min) == true) && is_null($max) == false && isset($max) == true) {
					if($min == $max) { if($variable == $min) { $results = true; }}
					if($variable >= $min && $variable <= $max) { $results = true; }
				} else if(((is_null($min) == false && isset($min) == true) && (is_null($max) == true || isset($max) == false))) { if($variable >= $min) { return true; } 
				} else if(((is_null($max) == false && isset($max) == true) && (is_null($min) == true || isset($min) == false))) { if($variable <= $max) { return true; }}
			} else if(is_string($variable)) {
				if((is_null($min) == false && isset($min) == true) && is_null($max) == false && isset($max) == true) {
					if($min == $max) { if(strlen($variable) == $min) { $results = true; } }		
					if(strlen($variable) >=$min && strlen($variable) <= $max) { $results = true; }
				} else if(((is_null($min) == false && isset($min) == true) && (is_null($max) == true || isset($max) == false))) {
					if(strlen($variable) >=$min) { $results = true; }
				} else if(((is_null($max) == false && isset($max) == true) && (is_null($min) == true || isset($min) == false))) {
					 if(strlen($variable) <= $max) { return true; }
				}
			}
		}
	}
	return $results;
}

/* retrieves the variable name of the passed in variable as a string 
   however function does not return the correct variable is value is same. */
function variable_name($variable) {
	$results = 'undefined';
	if(is_ready($variable) == true) {
		foreach($GLOBALS as $var_name => $value) { if ($value === $variable) { $results = $var_name; } }
	}
    return $results;
}

/* validates if input is a valid md5 string, checks for corresponding regex in /tools/contants/regex when defined in /tools/constants/constants $allowed_hash_types */
function validate_hash($hash, $hash_type = 'md5') { 
	$results = false;
	if(array_contains($hash_type, Constants::get('allowed_hash_types'), false)) {
		$results = preg_match(Regex::get('hash_' . strtolower($hash_type) . '_regex'), $hash);
	} else { $results = false; }
	return $results;
}

/* validates the email address formatting and ensure that the domain exist */
function validate_email($email){
   $is_valid = true; $at_index = strrpos($email, "@");
   
   if (is_bool($at_index) && !$at_index) { $is_valid = false; 
   } else {
      $domain = substr($email, $at_index + 1);
      $local = substr($email, 0, $at_index);
      $local_length = strlen($local);
      $domain_length = strlen($domain);
      if ($local_length < 1 || $local_length > 64) { $is_valid = false; //local part length exceeded
      } else if ($domain_length < 1 || $domain_length > 255) { $is_valid = false; //domain part length exceeded 
      } else if ($local[0] == '.' || $local[$local_length - 1] == '.') { $is_valid = false; //local part starts or ends with '.'
      } else if (preg_match('/\\.\\./', $local)) { $is_valid = false; //local part has two consecutive dots
      } else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) { $is_valid = false; // character not valid in domain part
      } else if (preg_match('/\\.\\./', $domain)) { $is_valid = false; // domain part has two consecutive dots
      } else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))) { //character not valid in local part unless local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local))) { $is_valid = false; }
      }
      if ($is_valid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A"))) { $is_valid = false; } //domain not found in DNS
    }
   return $is_valid;
}

/* check if server is requested with ssl */
function validate_https() { return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443; }
?>