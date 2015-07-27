<?php

$script = 'tools/object/tool.php';
echo 'Current Test Script: ' . $script . '<br/>';

/***** BEGIN FILE TESTING HERE *****/
include_once($script);


echo '<h3>Tool</h3>';

include_once($script);
use tools\object\Tool as Tool;

/* prepares and prints the error, writes to log if indicated 
 * requires two array of data to be passed in $info(class_name, method_name, return_type) - return_type default at json
 * $error(message, details, line, error_code) - error_code default at 400
 * $loggable default at false (if true, writes to log)
 */
echo '<hr/>Signature: public static function error($info, $error, $loggable = false) <br/>';
echo '// $info(class_name, method_name, return_type) <br/>';
echo '// $error(message, details, line, error_code) - error code default at 400. <br/><br/>'; 

echo 'Data input: <br/>'; 
echo '$info("class_name"=> __NAMESPACE__, "$method_name"=>__METHOD__, "$return_type"=>"json")<br/>';
echo '$error("message"=>"message","details"=>"details", "error_code"=>404) <br/>';
echo 'Tool::error($info, $error, false): '; 

$info = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__, 'return_type'=>'json'); $error = array('message'=>'message', 'details'=>'details', 'error_code'=>404);
Tool::error($info, $error, false);

?>  
