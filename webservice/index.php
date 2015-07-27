<?php

include_once('path.config.php'); //load the default path, this is required for all scripts to derive its position
require_once('tools/object/tool.php');
require_once('tools/constants/constants.php');
require_once('tools/router/router.php');
require_once('tools/router/route.php');
require_once('tools/validation/validator.php');

use tools\constants\Tool as Tool;
use tools\constants\Constants as Constants;
use tools\router\Router as Router;
use tools\router\Route as Route;

/** index.php 
 * default interception page for all request made to the web service
 * handles all redirection according to the link request
 */

//verify for maintenance
//verify for interception

$request = $_SERVER['QUERY_STRING'];
if(is_ready($request)) { 
	
	//normalize the request (remove path= and variables after &)
	$request = str_replace('path=', '', $request); 
	//extract the required path only
	$count = (strpos($request, '&') == false) ? strlen($request) : strpos($request, '&');
	$request = substr($request, 0, $count);
	$request_path = explode("/", $request);
	
	//extract return type, check if return type is in the allowed list
	$return_type = end($request_path); 
	$return_type = set_default($return_type, Constants::get('default_return_type'));
	$return_type = strrchr($return_type, "."); $return_type = substr($return_type, 1);
	
	$allowed_return_types = Constants::get('allowed_return_types');
	if(array_contains($return_type, $allowed_return_types, false) == false) { $return_type = Constants::get('default_return_type'); }
	else { //remove the return type from the request_path
		$item = end($request_path);
		$item = substr($item, 0, (strlen($item) - (strlen($return_type) + 1)));
		$request_path[count($request_path) - 1] = $item;
	}
	
	//extract request_method, can be defined in both get and post reauest, post takes precedence
	$request_method = set_default($_REQUEST['request_method'], Constants::get('default_http_method'));
	$allowed_http_methods = Constants::get('allowed_http_methods');
	if(array_contains($request_method, $allowed_http_methods, false) == false) { $request_method = Constants::get('default_http_method'); }

	//form route and send through router
	$route = new Route($request_path, $request_method, $return_type);
	$router = new Router($route);
	$router->route();
	
  //TODO: Can handle redirection to api introduction if no specific request is made 
} else { }



?>