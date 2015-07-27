<?php

namespace tools\database;

require_once('tools/constants/config.php');
require_once('tools/database/database.config.php');

use tools\constants\Config as Config;
use tools\database\Config as DatabaseConfig;

/** tools/database/helper.php 
 * helper class to manage all connection and data from database requests
 */
class DatabaseHelper {
	
	var $connection = null;
	var $statement = null;
	
	public function __construct($route) {
		
		try {
			$this->connection = new PDO('mysql:host=' . DatabaseConfig::get('host') . ';dbname=' . DatabaseConfig::get('database'), DatabaseConfig::get('username'), DatabaseConfig::get('password'));
			$exception_mode = (Config::get('enable_debugging') == true) ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT;			
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, $exception_mode);
			
		} catch(\PDOException $exception) {
			echo 'error';
			//Writer::write(500, array('Unable to connect to database.', $exception->getMessage(), true, 'e'), Constants::get('error_tag'), parent::get_return_type());
		}
	}
	
	
}

?>