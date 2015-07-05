<?php

namespace tools\constants;

/* tools/contants/regex.php 
 * contains the regex to validate the commonly used variables
 */
 
class Regex {
	
	//general regex
	private static $email_regex = '';
	private static $alphanumeric_regex = '/[^a-z_\-0-9]/i';
	
	//hash regex, hash must be named in $hash_*hash_type*_regex format corresponding to the constants defined $allowed_hash_type is required
	private static $hash_md5_regex = '/^[a-f0-9]{32}$/';
	
	//access method
	public static function get($key) { return self::$$key; }
}

?>