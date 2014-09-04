<?php

// ------------------------------------------------------------------------
class UserTableSeeder extends Seeder {

	public function run() {
		

		// create default user asset
		$asset = Asset::where('filename', '=', 'default.png')->first();
		if($asset == NULL) {
			$asset = new Asset;
  			$asset->filename = 'default.png';
		  	$asset->path = 'assets/content/users'; 
		  	$asset->save();
		}

		$admin = Role::where('name', '=', 'Admin')->first();

		// create default roles
		if($admin == NULL) {
			$admin = new Role;
			$admin->name = 'Admin';
			$admin->save();
		}


		$adminUser = User::where('username', '=', 'admin')->first();

		if($adminUser != NULL) {
			echo "Admin User Already Exsit";
		}
		else {

			$adminUser = new User;

			
			$adminUser->username = 'admin';
			$adminUser->email = 'admin@admin.com';
			$adminUser->password = 'admin';
			$adminUser->password_confirmation = 'admin';
		    $adminUser->confirmation_code = md5(uniqid(mt_rand(), true));

		    if($adminUser->save()) {
				$adminUser->attachRole( $admin );
		    	echo "Admin User Created";
		    }


		}
		


	}

}