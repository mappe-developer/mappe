<?php

namespace tools\constants;

/* tools/contants/limits.php 
 * contains limits to be shared commonly by variables defining their minimum and maximum limits
 */
 
class Limits {
	
	//shared limits
	private static $zero_minimium = 0;
	private static $id_limit = array('min' => 1, 'max' => 2147483647);
	private static $shorttext_limit = array('min' => 1, 'max' => 50);
	private static $text_limit = array('min' => 1, 'max' => 255);
	private static $password_limit = array('min' => 7, 'max' => 30);
	private static $password_hash_limit = array('min' => 32, 'max' => 32);
	private static $email_limit = array('min' => 3, 'max' => 320);
	private static $ip_address_limit = array('min' => '7', 'max' => 45);
	
	//access method
	public static function get($key) { return self::$$key; }
}

?>