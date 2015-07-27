<?php

namespace access\controller;

require_once('tools/object/tool.php');
require_once('tools/router/router.php');
require_once('tools/writer/writer.php');

use tools\constants\Tool as Tool;
use tools\router\Router as Router;
use tools\writer\Writer as Writer;
 
class Inner extends Router {
	
	public function __construct($route) { 
		parent::__construct($route);
		//check if route is completed, if uncompleted redirect
		$this->route();
		
		echo 'ENTERED INNER <br/>';
		print_r(parent::get_route()->get_request_path()); 
		$this->execute_request();
		$this->route_complete();
	}
	
	//handles the get request (used for retrieve records)
	public function get() { echo 'inner get'; }
	
	//handles the post request (used to create records)
	public function post() { echo 'inner post'; }
	
	//handles the put request (used to update records)
	public function put() { echo 'inner put'; }
	
	//handles the delete request (used to remove records)
	public function delete() { echo 'inner delete'; }
}

?>