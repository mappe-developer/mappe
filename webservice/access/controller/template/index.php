<?php

namespace access\controller;

require_once('tools/object/controller.php');
require_once('tools/object/tool.php');
require_once('tools/router/router.php');
require_once('tools/writer/writer.php');

require_once('access/classes/template/accessor.php');

use tools\object\Controller as Controller;
use tools\constants\Tool as Tool;
use tools\router\Router as Router;
use tools\writer\Writer as Writer;

use access\classes\template\Accessor as Accessor;

class Template extends Router implements Controller {
	
	public function __construct($route) { 
		parent::__construct($route);
		//check if route is completed, if uncompleted redirect
		$this->route();
		
		//echo 'ENTERED TEMPLATE <br/>';
		$this->execute_request();
		$this->route_complete();
	}
	
	//handles the get request (used for retrieve records)
	public function get() { 
		$route = parent::get_route();
		$accessor = new Accessor($route);
		$accessor->get_accessor($route->get_request_path(), $route->get_post_params());
	}
	
	//handles the post request (used to create records)
	public function post() { 
		$route = parent::get_route();
		$accessor = new Accessor($route);
		$accessor->create_accessor($route->get_request_path(), $route->get_post_params());
	}
	
	//handles the put request (used to update records)
	public function put() { 
		$route = parent::get_route();
		$accessor = new Accessor($route);
		$accessor->update_accessor($route->get_request_path(), $route->get_post_params());
	}
	
	//handles the delete request (used to remove records)
	public function delete() { 
		$route = parent::get_route();
		$accessor = new Accessor($route);
		$accessor->delete_accessor($route->get_request_path(), $route->get_post_params());
	}
}

?>