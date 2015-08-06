<?php

namespace tools\router;

require_once('tools/object/tool.php');
require_once('tools/validation/validator.php');
require_once('tools/constants/config.php');
require_once('tools/constants/constants.php');
require_once('tools/writer/writer.php');

use tools\constants\Config as Config;
use tools\constants\Constants as Constants;
use tools\object\Tool as Tool;
use tools\writer\Writer as Writer;

/** tools/router/router.php 
 *  contains method that does the forwarding of request to the respective scripts
 */
class Router {
	
	var $route = null;
	
	public function __construct($route) {
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);	
		//validate if route is valid else throw error
		if(is_ready($route)) { $this->route = $route; 
		} else { //route is invalid, throw error
			$error = Tool::prepare('Route is invalid, unable to process routing request.', 'Route is null, verify that index router has parsed the information correctly.', __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		}
	} 
	
	public function route() {
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
		//process route to send to next hop address
		if(is_ready($this->route)) {
			//calculate next hop address to determine if address is a controller or action
			$this->route->pop_request_path();
			//adds the necessary includes to handle the request
			$this->handle_include($this->route->get_current_location());
		} else { 
			$error = Tool::prepare('Route is invalid, unable to process routing request.', 'Route is null, verify that index router has parsed the information correctly.', __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		}
	}
	
	private function handle_include($current_location) {
		$controller = end($current_location);
		if(is_ready($controller) == false) { return; }
		
		//form the string to parse location
		$current_location = implode('/', $this->route->get_current_location());
		
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
		//prepare location for directory and file from current location
		$include_path = getcwd() . Constants::get('controller_location') . '/' . $current_location;
		$directory_location = $include_path . '/index.php'; //for directory, redirect to index router (controller)
		$file_location = $include_path . '.php'; //for file, check if action exists (action)
		
		//check if include_path is a directory location, send to index router
		if(is_dir($include_path)) { 
			//check if router is attatched to controller if indicated
			if(file_exists($directory_location)) {
				include_once($directory_location);
				//send the router the corresponding route
				$class_name = Constants::get('controller_reference') . '\\' . $controller;
				$router = new $class_name($this->route);
			} else { 
				$error = Tool::prepare('Router is not installed. (controller/index.php) - ' . $directory_location, 'Ensure the .index.php router is provided for the controller indicated.', __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
				Tool::error($function, $error, false);
			}
		
		//check if file location is a file, send to action
		} else if(file_exists($file_location)) { 
			include_once($file_location);
			//send the router the corresponding route 
			$class_name = Constants::get('controller_reference') . '\\' . $controller;
			$router = new $class_name($this->route);
			
		//add variables back into the list if directory matches
		} else { $this->route->push_request_path(); }
	}
	
	//returns the current route restored in the router
	public function get_route() { return $this->route; }
	
	//direct the request to the correct request method
	public function execute_request() { 
		$request_method = $this->route->get_request_method();
		$this->$request_method();
	}
	
	//notify that route is completed (called at the end of each controller and action
	public function route_complete() { exit(); }
}

?>