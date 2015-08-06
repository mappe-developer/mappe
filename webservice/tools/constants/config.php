<?php

namespace tools\constants;

/* tools/contants/config.php 
 * contains the configuration and settings for the service options.
 */
 
class Config {
	
	//security configurations
	//private static $enable_https = true; //ensures that methods/functions that require https is enforced. (true*/false)
	//private static $enable_permissions = true; //ensures that methods/functions that require permissions are enforced. (true*/false) - requires database connection
	//private static $enforce_admin_https = true;
	//private static $enforce_authentication_https = true;
	
	//debugging configurations - shows complex message in errors, raise exceptions in database
	private static $enable_debugging = false;
	
	//logging configurations
	//private static $enable_logging = true; //enables logs to be written to the specific file provided. (true*/false)
	//private static $logging_location = ''; //defines custom logging location, default folder when empty ($error_folder + 'logs')
	
	//subdomain, maintenance and redirection configurations
	//private static $enable_subdomains = false; //redirect subdomain requests to the subdomain folder (true/false*)
	//private static $service_status = 'live'; //defines if the services are live or in maintenance, the page would reflect the error accordingly. (live/maintenance)
	//private static $service_statuses = array('live', 'maintenance');
	//private static $maintenance_start_time = '2014-08-04  1700';
	//private static $maintenance_estimated = '2014-08-05  1500';
	//private static $status_message = 'The service is currently down for maintenance. Please try again later.';
	//private static $maintenance_location = ''; //defines custom maintenance redirection page, else only maintenance information is returned.
	 
	//versioning configurations
	//private static $current_version = '1.0'; //defines the current version of the framework
	//private static $min_database_version = '1.0'; //defines the minimum version the framework has to work with
	
	//timezone configurations
	//private static $default_timezone = 'Asia/Singapore';
	
	//access method
	public static function get($key) { return self::$$key; }
}
?>