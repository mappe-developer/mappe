<?php

namespace tools\object;

/** tools/object/controller.php 
 * contains get/post/put/delete interface methods
 */
interface Controller {
	public function get();
	public function post();
	public function put();
	public function delete();
}

?>