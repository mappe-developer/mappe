<?php

namespace tools\database;

require_once('tools/constants/config.php');
require_once('tools/constants/constants.php');
require_once('tools/database/database.config.php');

use tools\constants\Config as Config;
use tools\constants\Constants as Constants;
use tools\database\Config as DatabaseConfig;
use \PDO as PDO;

/** tools/database/helper.php 
 * helper class to manage all connection and data from database requests
 */
class DatabaseHelper {
	
	var $connection = null;
	var $statement = null;
	var $route = null;
	
	public function __construct($route) { 
		
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
		
		//ensure that route is valid else send error
		if(is_ready($route)) { $this->route = $route; }
		else { 
			$error = Tool::prepare('Route is invalid, unable to process routing request.', 'Route is null, verify that index router has parsed the information correctly.', __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		}
		
		try {
			$this->connection = new PDO('mysql:host=' . DatabaseConfig::get('host') . ';dbname=' . DatabaseConfig::get('database'), DatabaseConfig::get('username'), DatabaseConfig::get('password'));
			$exception_mode = (Config::get('enable_debugging') == true) ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT;			
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, $exception_mode);
		} catch(\PDOException $exception) {
			$error = Tool::prepare('Unable to connect to database.', $exception->getMessage(), __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		}
	}
	
	public function query($query) {
		$this->statement = $this->connection->prepare($query);
	}
	
	public function execute($bindings = null, $write_statement = false) {
		
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);
				
		try {
			$this->statement->execute($bindings);
			if($write_statement == false) { return $this->statement->fetchAll(PDO::FETCH_ASSOC); }
		} catch (PDOException $exception) {
			$error = Tool::prepare('Unable to execute statement.', $exception->getMessage(), __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);	
		}
	}
	
	public function row_count() { return $this->statement->rowCount(); }
	
	public function last_insert_id() { return $this->connection()->lastInsertId(); }
	
	public function statement() { return $this->statement; }
	
	public function connection() { return $this->connection; }
	
	public function generate_selects($retrieved_keys) {
		$results = '';
		while(list($key, $value) = each($retrieved_keys)) {
			$results .= ' ' . $value . ' ' . $key . ', ';
		}
		
		return rtrim($results, ', ') . ' ';
	}
	
	public function close() {
		$this->connection = null;
		$this->statement = null;
	}	
	
}

?>