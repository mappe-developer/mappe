<?php

$script = 'tools/validation/enforcer.php';
echo 'Current Test Script: ' . $script . '<br/>';

/***** BEGIN FILE TESTING HERE *****/
include_once($script);


/*echo '<h3>Enforcement - Ensure the required information is provided, throws error if unmatched (kills all subsequent scripts)</h3>';*/
/* Takes in an array of arrays containing the variable inputs and their requirements. Error will be thrown if requirements are not met. 
 * It takes in a variable list of variables, but requiring every variable to be an array of requirements.
 * The last parameter it takes is maybe a boolean ($simple) or omitted, if present, it will alter the returned results.
 * The list of array validation requirement format is as follow - [variable, type, min, max, nullable*]
 * However, the min, max can be replaced by an array list in either with the other as null, it will be able to validate if it exist in the list passed in.
*/


echo '<hr/>Signature: function enforce_inputs() <br/>';
echo 'enforce_inputs(): ' . (enforce_inputs()) . '<br/>';


//echo 'enforce_inputs(array($data, "string:array", null, null, false)) ' . (enforce_inputs(array($data, 'string:array', null, null, false))) . ' - empty variable <br/><br/>';
$data = 123; echo '$data = 123 <br/><br/>'; 
echo ' enforce_inputs(array($data, "xxxx", null, null, false)) - invalid type ' . ' <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", "b", "a", false)) - invalid min max <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", null, 5, false)) - validate only one side <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", null, null, false)) - no validation for min/max <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", array("a"), null, false)) - setting validation list (left) <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", null, array("b"), false)) - setting validation list (right) <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", array("a"), array("b"), false)) - setting validation list (both), min take precendence <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", "x", array("a"), false)) - array must be on left <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", array("a"), "x", false)) - array must be on left <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", null, "x", false)) - array must be on left <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", 5, 3, false)) - min more than max <br/><br/>';
echo ' enforce_inputs(array($data, "numeric", null, null, 10)) - nullable must be boolean <br/><br/>';
echo ' enforce_inputs(array($data, "string", null, null, 10)) - Variable not a string <br/><br/>';

echo " enforce_inputs(array($data, 'xxxx', null, null, false), 'json'); - takes in the return type <br/><br/>";
echo " enforce_inputs(array($data, 'xxxx', null, null, false), 'xml'); - takes in the return type <br/><br/>";
echo " enforce_inputs(array($data, 'xxxx', null, null, false)); - return type not given as last variable, default json <br/><br/>";
echo " enforce_inputs(array($data, 'xxxx', null, null, false), 'xxxx'); - return type not given as last variable, default json <br/><br/>";
echo " enforce_inputs(array($data, 'xxxx', null, null, false), 'xxxx'); - invalid return type default json used <br/><br/>";

echo " enforce_inputs(array($data, 'string', 0, 15, true), 'xxxx'); - if minimum is 0, nullable must be set to true <br/><br/>";

$data = '123';
enforce_inputs(array($data, 'xxxx', null, null, false), 'json');


?>  
