<?php

/* path.config 
 * requires to be located at the root folder of the whole router 
 * tells the relative position of other folders based on the location of the directory
 */
 
set_include_path (getcwd() . '/');

/* enable  debugging output */
ini_set('display_errors', E_ALL);
ini_set('display_startup_errors', E_ALL);
error_reporting(E_ALL);

?>
