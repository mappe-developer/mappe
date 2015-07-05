<?php

$script = 'tools/writer/writer.php';
echo 'Current Test Script: ' . $script . '<br/>';

/***** BEGIN FILE TESTING HERE *****/
include_once($script);


echo '<h3>Writer</h3>';

include_once($script);;
use tools\writer\Writer as Writer;

/* prints the requested data (error or normal) and return the response as per http status code
	 * $http_status_code accepted are defined in tools/constants/constants.php - $http_status_codes
	 * $data are accepted in either simple text eg. 'error message goes here' or in an array where it contains the return results
	 * $parent_tag can be in any text form, however if the $parent_tag used is the reserved $error_tag defined in tools/constants/constants.php, it will print as an error
	 * $return_type accepted are defined in tools/constants/constants.php - $allowed_return_types
	 */

echo '<hr/>Signature: write($http_status_code, $data, $parent_tag, $return_type = "json")<br/>'; 
echo 'Writer::write(200, "asd", "parent", "json") <br/>' . Writer::write(200, 'asd', 'parent', 'json');

?>  
