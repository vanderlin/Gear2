<?php 

use core\models\User as CoreUser;

class User extends CoreUser {
	
	public function my_extended_function() {
		return $this->username.'_extened';
	}
}