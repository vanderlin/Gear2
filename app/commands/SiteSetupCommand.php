<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SiteSetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'site:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup the Laravel starter site.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	// ------------------------------------------------------------------------
	static function saveConfig() {

	}


	// ------------------------------------------------------------------------
	public function createAdminUser() {

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
	// Migrate the database
	// ------------------------------------------------------------------------
	public function migrateTheDatabase() {
		
		$this->call('migrate', array('-n'=>true));

	}

	// ------------------------------------------------------------------------
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {

		$this->line("\n*******************************");
		$this->line('Setting up Laravel Starter Site');
		$this->line("*******************************\n");

		 // create a admin user?
        if($this->confirm('Setup local database credentials? [yes|no]', true)) {
			
			$creds = [
				'hostname' => Config::get('database.connections.mysql.host'),
				'database' => Config::get('database.connections.mysql.database'),
				'username' => Config::get('database.connections.mysql.username'),
				'password' => Config::get('database.connections.mysql.password'),
				'prefix'   => Config::get('database.connections.mysql.prefix'),
			];	



			 // array (
		    //   'driver' => 'mysql',
		    //   'host' => 'localhost',
		    //   'database' => 'dev',
		    //   'username' => '*** this is new ***',
		    //   'password' => 'root',
		    //   'charset' => 'utf8',
		    //   'collation' => 'utf8_unicode_ci',
		    //   'prefix' => 'site_',
		    // ),

			$creds['hostname'] = $this->ask("Hostname? ");			
			if($creds['hostname']) { 
				ConfigHelper::setAndSave('database.connections.mysql.host', $creds['hostname'], 'local');
			}

			$creds['database'] = $this->ask('Database name? ');			
			if($creds['database']) { 
				ConfigHelper::setAndSave('database.connections.mysql.database', $creds['database'], 'local');
			}

			$creds['username'] = $this->ask('Database username? ');			
			if($creds['username']) { 
				ConfigHelper::setAndSave('database.connections.mysql.username', $creds['username'], 'local');
			}

			$creds['password'] = $this->ask('Database password? ');			
			if($creds['password']) { 
				ConfigHelper::setAndSave('database.connections.mysql.password', $creds['password'], 'local');
			}

			$creds['prefix'] = $this->ask('Database prefix? ');			
			if($creds['prefix']) { 
				ConfigHelper::setAndSave('database.connections.mysql.prefix', $creds['prefix'], 'local');
			}

			$this->line("\n*******************************");
			$this->line("\n  Local Database Credentials   ");
			$this->line("*******************************\n");
			$creds = ConfigHelper::get('database.connections.mysql', 'local');
			foreach ($creds as $key => $value) {
				$this->line("{$key} = {$value}");
			}
			$this->line("\n");

        }


        return;

		 // create a admin user?
        if($this->confirm('Migrate the database? [yes|no]', true)) {
			$this->comment("\nMigrating the database...\n");        	
			$this->migrateTheDatabase();
        }

		$sitename = $this->option('sitename');

		if( $sitename == NULL) {
			$sitename = $this->ask('What is the name of this site? ');
			if($sitename) {
				Config::set('config.site-name', $sitename?$sitename:'Laravel Starter Site');
				ConfigHelper::save('config', 'production');				
			}
		}
        $this->comment("\nStarter site: {$sitename}\n");



        // site password
        if($this->confirm('Use a site password? [yes|no]', true)) {
        	$sitepassword = $this->ask('Enter a password for the site? ');
			if($sitepassword) { 
				$this->comment("\nPassword to enter site is: {$sitepassword}\n");        	
				Config::set('config.site-password', $sitepassword);
				Config::set('config.use_site_login', true);
				ConfigHelper::save('config', 'production');				
			}
        }
        



        // create a admin user?
        if($this->confirm('Do you want to create an Admin user? [yes|no]', true)) {
			$this->comment('\nCreating a Admin user with username "admin" and password "admin"\n');        	
			$this->createAdminUser();
        }

		$this->line("\n*******************************");
		$this->line('          All Done!			');
		$this->line("*******************************\n");

	}	

	// ------------------------------------------------------------------------
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			array('sitename', null, InputOption::VALUE_OPTIONAL, 'Name of this site.', null),
		);
	}

}
