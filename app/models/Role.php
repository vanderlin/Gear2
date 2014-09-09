<?php

use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\HasRole;

class Role extends EntrustRole {
	use HasRole;
	public static $rules = array(
      'name' => 'required|between:4,255'
    );
    
	

	public function hasPerm($perm_name) {
		
		foreach ($this->perms as $perm) {
			if($perm->name == $perm_name) return true;
		}
		return false;
	}
}