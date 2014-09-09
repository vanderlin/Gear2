<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UserGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'site:adduser';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add a new user';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}


	// ------------------------------------------------------------------------
	public function createAdminUser() {
		
		$this->comment("\nCreating a Admin user with username \"admin\" and password \"admin\"\n");     

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

			$this->error("Admin User Already Exist");

			if($this->confirm('Remove this Admin User? [yes|no]', true)) {
				$adminUser->delete();
				$adminUser = NULL;
	        }

		}
		
		if($adminUser == NULL) {
			$adminUser = new User;

			$adminUser->username = 'admin';
			$adminUser->email = 'admin@admin.com';
			$adminUser->password = 'admin';
			$adminUser->password_confirmation = 'admin';
		    $adminUser->confirmation_code = md5(uniqid(mt_rand(), true));

		    if($adminUser->save()) {
				$adminUser->attachRole( $admin );
		    	$this->comment("Admin User Created");
		    }
		}

		
		
	}

	// ------------------------------------------------------------------------
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		if($this->argument('admin-user')) {
			$this->comment('Adding Admin User');
			$this->createAdminUser();
		}


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(
			array('admin-user', InputArgument::OPTIONAL, 'Add admin user'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			// array('admin-user', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
