<?php namespace Vanderlin\Slate\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Asset;
use Role;
use User;


class UserGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'slate:adduser';

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
  			$asset->org_filename = 'default.png';
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
	public function fire() {
		
		if($this->option('admin') != null) {
			$this->comment('Adding Admin User');
			$this->createAdminUser();
		}

		if($this->option('username') != null && $this->option('email') && $this->option('password')) {
			$this->comment("Creating user:{$this->option('username')}");
			
			$user = new User;
			$user->username = $this->option('username');
			$user->email = $this->option('email');
			$user->password = $this->option('password');
			$user->password_confirmation = $this->option('password');
		    $user->confirmation_code = md5(uniqid(mt_rand(), true));
		    if($user->save()) {
		    	$this->comment("User Created");
		    }
		    else {
		    	foreach ($user->errors()->all() as $err) {
		    		$this->error($err);
		    	}
		    	
		    }
		}

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return array(

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
			array('admin', null, InputOption::VALUE_OPTIONAL, 'Create and Admin user.', null),
			array('username', null, InputOption::VALUE_OPTIONAL, 'Enter username', null),
			array('email', null, InputOption::VALUE_OPTIONAL, 'Enter email', null),
			array('password', null, InputOption::VALUE_OPTIONAL, 'Enter password', null),
		);
	}

}
