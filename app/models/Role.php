<?php

use Zizaco\Entrust\EntrustRole;
use Zizaco\Entrust\HasRole;

class Role extends EntrustRole {
	use HasRole;

	public function hasPerm($perm_name) {
		
		foreach ($this->perms as $perm) {
			if($perm->name == $perm_name) return true;
		}
		return false;
	}
}