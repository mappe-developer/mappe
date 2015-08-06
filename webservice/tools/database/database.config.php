<?php

namespace tools\database;

/* tools/database/database.config.php 
 * contains the configuration and settings for database options.
 */
 
class Config {
	
	//database configurations
	private static $host = 'localhost'; 	
	private static $username = 'root'; 	
	private static $password = 'twc_password'; 	
	private static $database = 'mappe'; 	
	private static $unix_socket = '/tmp/mysql.sock';

	//access method
	public static function get($key) { return self::$$key; }
}

?>
