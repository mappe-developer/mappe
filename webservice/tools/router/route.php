<?php

namespace tools\router;

require_once('tools/validation/validator.php');
require_once('tools/constants/config.php');
require_once('tools/constants/constants.php');
require_once('tools/writer/writer.php');

use tools\constants\Config as Config;
use tools\constants\Constants as Constants;
use tools\writer\Writer as Writer;

/** tools/router/route.php 
 * contains the useful information of the request that allows the router to know the path
 */
class Route {
	
	var $original_path = null; //original path assigned at construct
	var $return_type = null; //return type of the request
	
	var $request_path = null; //request path is to be pop and reduced
	var $current_location = array(); //stores the popped location of request path
	
	var $route_status = false;
	var $request_method = null;
	
	//default constructor: checks if the variables qualify and assign them to the class variable. throws error accordingly
	public function __construct($request_path, $request_method, $return_type) { 
	
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
		
		//validating the return type and set default if not found
		if(array_contains($return_type, Constants::get('allowed_return_types') == false)) { $return_type = Constants::get('default_return_type'); 
		} else { $this->return_type = set_default($return_type, Constants::get('allowed_return_types')); }
		
		//validate if request path is valid else throw error
		if(is_ready($request_path) == false) {
			$error = Tool::prepare('Request path is invalid, unable to process routing request.', 'Request path is null, verify that index router has parsed the information correctly.', __LINE__, $this->return_type, Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		} else {
			enforce_inputs(array($request_path, 'array', null, null, false), $this->return_type);
			$this->original_path = $request_path;
			$this->request_path = $request_path;
		}
		
		//validate if request method is valid, else set as default (post takes precendence if both are used)
		$this->request_method = set_default($request_method, Constants::get('default_http_method'));
		$allowed_http_methods = Constants::get('allowed_http_methods');
		if(array_contains($request_method, $allowed_http_methods, false) == false) { $request_method = Constants::get('default_http_method'); }
		$this->request_method = strtolower($request_method); 
	}
	
	//returns the original path received at constructor
	public function get_original_path() { return $this->original_path; }
	//returns to remaining path of the request
	public function get_request_path() { return $this->request_path; }
	//removes the first item in the request path, used when the item has reached its location
	public function pop_request_path() { $item = array_shift($this->request_path); array_push($this->current_location, $item); return $item; }
	//returns the current next hop location (next location to go to) for the route
	public function get_current_location() { return $this->current_location; }
	//removes the last known current location to return back to the request path (revert pop_request_path())
	public function push_request_path() { $item = end($this->current_location); array_unshift($this->request_path, $item); }
	//return the return type for this request
	public function get_return_type() { return $this->return_type; }
	//return the request method for this request
	public function get_request_method() { return $this->request_method; }
}

?>