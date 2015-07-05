<?php

$script = 'tools/validation/validator.php';
echo 'Current Test Script: ' . $script . '<br/>';

/***** BEGIN FILE TESTING HERE *****/
include_once($script);


echo '<h3>General Variable Manipulation</h3>';

/* function is_ready($variable = null) 
 * takes in an input by reference and check if it isset, is_null, or is an empty string
 * if variable isset, not null and is not an empty string, returns true, otherwise returns false
 */ 
echo '<hr/>Signature: is_ready($variable = null)<br/>';
echo '//variable must not be null and empty<br/><br/>';
echo 'is_ready("x"): ' . (is_ready('x') ? 'true' : 'false') . '<br/>';
echo 'is_ready(null): ' . (is_ready(null) ? 'true' : 'false') . '<br/>';
echo 'is_ready(""): ' . (is_ready('') ? 'true' : 'false') . '<br/>';
echo 'is_ready(" "): ' . (is_ready(" ") ? 'true' : 'false') . '<br/>';
 
echo '<br/>Passed<br/><hr/>';
 
 
 /* function sanitize_input($string_input)
  * takes in the user input, returns the trimmed and escaped user input.
  * @$string_input will process strings or an array of strings
  * original value of the variable will be returned if it is unable to trim or/and escape the input.
  */
 
echo 'Signature: sanitize_input($string_input)<br/>';
echo '//removes all trailing spaces for individual input and array input<br/><br/>';
echo 'sanitize_input("x"): "' . sanitize_input('x') . '"<br/>';
echo 'sanitize_input("x "): "' . sanitize_input('x ') . '"<br/>';
echo 'sanitize_input(array()):'; print_r(sanitize_input(array())); echo '<br/>';
echo 'sanitize_input(array("sample one", "sample two ", "three ")):   --result:'; print_r(sanitize_input(array("sample one", "sample two ", "three "))); echo '<br/>';
 
echo '<br/>Passed<br/><hr/>';

 
/* checks if the variable is unset, null or empty and assign the default value 
 * if the variable is unset, null or empty (if string), the default value will be set to the variable. 
 * $variable will not be able to take in a value for eg. is_ready('abc');, a variable has to be used, eg. $x; is_ready($x);
 */
 
echo 'Signature: set_default(&$variable, $default)<br/>';
echo '//sets a default if variable is not ready. variable must be passed. value is return and assigned.<br/><br/>';
$default_value = 'defaultvalue';
$normal_item = 'x';
$null_item = null;
$empty_item = '';
$single_space = ' ';

echo 'set_default($normal_item, "default"): ' . (set_default($normal_item, 'default')). '<br/>';
echo 'set_default($null_item, "default"): ' . (set_default($null_item, 'default')) . '<br/>';
echo 'set_default($empty_item, "default"): ' . (set_default($empty_item, 'default')) . '<br/>';
echo 'set_default($single_space, "default"): ' . (set_default($single_space, 'default')) . '<br/>';

echo '<br/>Passed<br/><hr/>';

/* Rewrite method of in_array to check if the array contains the item. However, it sanitizes the input before checking */
echo 'Signature: array_contains($item, $allowed_array, $case_sensitive = false)<br/>';
echo '//check if items is in array, but sanitize all input before checking, default not case sensitive<br/><br/>';

echo 'array_contains("x ", array("x", "y", "z")): ' . (array_contains("x ", array("x", "y", "z")) ? 'true' : 'false') . '<br/>';
echo 'array_contains("x ", array("x ", "y", "z")): ' . (array_contains("x ", array("x", "y", "z")) ? 'true' : 'false') . ' - both inputs and list are sanitized<br/>';
echo 'array_contains("X ", array("x ", "y", "z")): ' . (array_contains("X ", array("x", "y", "z")) ? 'true' : 'false') . '<br/>';
echo 'array_contains("X ", array("x ", "y", "z"), true): ' . (array_contains("X ", array("x", "y", "z"), true) ? 'true' : 'false') . '<br/>';



echo '<h3>String Manipulation</h3>';

/* rewrite method of strcmp which sanitizes and trim inputs, including case sensitive comparision */
echo '<hr/>Signature: compare_string($input_one = "", $input_two = "", $case_sensitive = false)<br/>';
echo '//default comparision is not case sensitive, passing variables in works accordingly.<br/><br/>';

echo 'compare_string("", ""): ' . (compare_string('', '') ? 'true' : 'false') . '<br/>';
echo 'compare_string("xyz", "xyz"): ' . (compare_string('xyz', 'xyz') ? 'true' : 'false') . '<br/>';
echo 'compare_string("xyz", "XYZ"): ' . (compare_string('xyz', 'XYZ') ? 'true' : 'false') . '<br/>';
echo 'compare_string("xyz", "XYZ", true): ' . (compare_string('xyz', 'XYZ', true) ? 'true' : 'false') . '<br/>';

echo '<br/>Passed<br/><hr/>';

/* takes in a string list of items separated by the ':', it matches it against an array to check if the item exist in the array
   function is similar to array_contains/in_array however it allows multiple items to be validated at the same time
   @$greedy is a boolean value, when set to true, all items set to validate against the list must match
   if @$greedy is set to false, as long as any item matches, true is returned
*/

echo 'Signature: list_contains($items, $list, $greedy = true)<br/>';
echo '//greedy is used to compare two list, if true, all items in both list must match, if false, as long one match it is true <br/><br/>';

echo 'list_contains("xyz", array("abc", "def", "ghi")): ' . (list_contains("xyz", array("abc", "def", "ghi")) ? 'true' : 'false') . '<br/>'; 
echo 'list_contains("xyz", array("abc", "def", "xyz")): ' . (list_contains("xyz", array("abc", "def", "xyz")) ? 'true' : 'false') . '<br/>';
echo 'list_contains("xyz", array("abc", "def", "xyz"), true): ' . (list_contains("xyz", array("abc", "def", "xyz"), true) ? 'true' : 'false') . ' - no effect <br/>' ;
echo 'list_contains("xyz", array("abc", "def", "xyz"), false): ' . (list_contains("xyz", array("abc", "def", "xyz"), false) ? 'true' : 'false') . ' - no effect <br/>' ;
echo 'list_contains("abc:def:khl", array("abc", "def", "xyz"), true): ' . (list_contains("abc:def:khl", array("abc", "def", "xyz"), true) ? 'true' : 'false') . '<br/>' ;
echo 'list_contains("abc:def:khl", array("abc", "def", "xyz"), false): ' . (list_contains("abc:def:khl", array("abc", "def", "xyz"), false) ? 'true' : 'false') . '<br/>' ;

echo '<br/>Passed<br/><hr/>';


/* takes in a string list of items separated by the ':', it matches it against an array keys to check if the item exist in the array
   function is checks if the keys exists in the array, list given must be an associative array (else return false)
   @$greedy is a boolean value, when set to true, all items set to validate against the list must match
   if @$greedy is set to false, as long as any item matches, true is returned
*/
echo 'Signature: list_contains_keys($items, $list, $greedy = true)<br/>';
echo '//similar to list_contains, but validates keys instead.  will not work with non-associative array, it will return false <br/><br/>';

echo 'list_contains_keys("0:1:2", array("abc", "def", "ghi")): ' . (list_contains_keys("0:1:2", array("abc", "def", "ghi"), false) ? 'true' : 'false') . ' - not associative<br/>'; 
echo 'list_contains_keys("one:two:three", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), true): ' . (list_contains_keys("one:two:three", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), true) ? 'true' : 'false') . '<br/>'; 
echo 'list_contains_keys("one", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), false): ' . (list_contains_keys("one", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), false) ? 'true' : 'false') . '<br/>'; 
echo 'list_contains_keys("one", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), true): ' . (list_contains_keys("one", array("one"=>"abc", "two"=>"def", "three"=>"ghi"), true) ? 'true' : 'false') . '<br/>'; 

echo '<br/>Passed<br/><hr/>';


echo '<h3>To Type Validation</h3>';

/* checks if the variable passed in is within the allow list of variable types (tools/constants/constants.php). List seperated by ":" 
   takes in additional parameter to ensure that password is string
   variable list can be as individual eg. 'string' or 'string:numeric', if any falls into the allowed list, it would be accepted. if greedy all must match
*/
echo 'Signature: validate_type($variable, $allowed_list, $greedy = false)';
echo '//check if the variable belongs to type. can pass in multiple eg string:numeric validation (either one match, returns true) <br/>';

echo 'validate_type("x", "string"): ' . (validate_type('x', 'string') ? 'true' : 'false') . '<br/>';
echo 'validate_type("x", "numeric"): ' . (validate_type('x', 'numeric') ? 'true' : 'false') . '<br/>';
echo 'validate_type("x", "string:numeric"): ' . (validate_type('x', 'string:numeric') ? 'true' : 'false') . '<br/>';
echo 'validate_type("x", "string:numeric", true): ' . (validate_type('x', 'string:numeric', true) ? 'true' : 'false') . ' //greedy all must match <br/>';
echo 'validate_type("x", "ajoke", true): ' . (validate_type('x', 'ajoke', true) ? 'true' : 'false') . ' //incorrect match will return false <br/>';

echo '<br/>Passed<br/><hr/>';

/* checks if the variable length/value falls within the minimum/maximum range provided 
   method validates both string and numeric values 
   if string is provided, string's length is matched
   if numeric is provided, the value of the numeric is matched
   true is returned whenever the matched value is equals to the min/max, more than equals to min, or lesser than equals to max
   if any other cases false is returned.
*/
echo 'Signature: validate_range($variable, $min, $max)<br/>';
echo '//can pass in string (calculates length), numeric (check number range) - min/max inclusive<br/>';

echo 'validate_range($variable_range("xyz", 0, 3): ' . (validate_range('xyz', 0, 3) ? 'true' : 'false') . '<br/>';
echo 'validate_range($variable_range("", 1, 3): ' . (validate_range('', 1, 3) ? 'true' : 'false') . '<br/>';
echo 'validate_range($variable_range("xyz", 0, 2): ' . (validate_range('xyz', 0, 2) ? 'true' : 'false') . '<br/>';
echo 'validate_range($variable_range(-1, 0, 2): ' . (validate_range(-1, 0, 2) ? 'true' : 'false') . '<br/>';
echo 'validate_range($variable_range(3, 0, 2): ' . (validate_range(3, 0, 2) ? 'true' : 'false') . '<br/>';
echo 'validate_range($variable_range("201", 0, 2): ' . (validate_range("201", 0, 200) ? 'true' : 'false') . '//numeric in string will be converted in numeric <br/>';

echo '<br/>Passed<br/><hr/>';

/* retrieves the variable name of the passed in variable as a string 
   however function does not return the correct variable is value is same. */
echo 'Signature: variable_name($variable)<br/>';
echo '//returns the variable name that was passed in';

$selected_item = 'item'; $arraylist_item = array('lalala');
echo 'variable_name($selected_item): ' . variable_name($selected_item) . '<br/>';
echo 'variable_name("test_item"): "' . variable_name("test_item") . '" >br/> //returns empty if variable is not an item<br/>';
echo 'variable_name($arraylist_item): ' . variable_name($arraylist_item). '<br/>';

echo '<br/>Passed<br/><hr/>';


/* validates if input is a valid md5 string, checks for corresponding regex in /tools/contants/regex when defined in /tools/constants/constants $allowed_hash_types */
echo 'Signature: validate_hash($hash, $hash_type = "md5")<br/>';
echo '#checks if hash type is valid based on list in constants.php, checks if hash given matches the relevant regex<br/><br/>';
echo 'validate_hash("123asd", "md5): ' . (validate_hash('123asd', 'md5') ? 'true' : 'false') . '<br/>';
echo 'validate_hash("123asd", "lalalhash"): ' . (validate_hash('123asd', 'lalahash') ? 'true' : 'false') . '//if hash type not valid false <br/>';
echo 'validate_hash("5f4dcc3b5aa765d61d8327deb882cf99"): ' . (validate_hash('5f4dcc3b5aa765d61d8327deb882cf99') ? 'true' : 'false') . '<br/>';

echo '<br/>Passed<br/><hr/>';

/* validates the email address formatting and ensure that the domain exist */
echo 'Signature: validate_email($email)<br/><br/>';
echo 'validate_email("googogo@email.com"): ' . (validate_email("googogo@email.com") ? 'true' : 'false') . '<br/>';
echo 'validate_email("abc.123@email.com"): ' . (validate_email("abc.123@email.com") ? 'true' : 'false') . '<br/>';
echo 'validate_email("91203123@email.com"): ' . (validate_email("91203123@email.com") ? 'true' : 'false') . '<br/>';
echo 'validate_email("googogo@123.com"): ' . (validate_email("googogo@123.com") ? 'true' : 'false') . '<br/>';
echo 'validate_email("googogo@123.123"): ' . (validate_email("googogo@123.123") ? 'true' : 'false') . ' //must be valid tld<br/>';
echo 'validate_email("googogo@123.123.123.123"): ' . (validate_email("googogo@123.123.123.123") ? 'true' : 'false') . '//ip address will not work<br/>';

echo '<br/>Passed<br/><hr/>';

/* check if server is requested with ssl */
echo 'Signature: validate_https()';
echo 'validate_https(): ' . (validate_https() ? 'true' : 'false') . '<br/>';
echo '<br/>Passed<br/><hr/>';

?>  
