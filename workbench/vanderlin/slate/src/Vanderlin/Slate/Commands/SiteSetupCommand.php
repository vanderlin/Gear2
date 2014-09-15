<?php namespace Vanderlin\Slate\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SiteSetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'slate:setup';

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
	// Migrate the database
	// ------------------------------------------------------------------------
	public function migrateTheDatabase() {
		
		$this->call('migrate', array('-n'=>true));

	}

	// ------------------------------------------------------------------------
	public function createGoogleCredentials() {
		$google_creds = array();

		$google_creds['api_key'] = $this->ask('API Key? ');			
		if($google_creds['api_key']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		$google_creds['app_name'] = $this->ask('App name? ');			
		if($google_creds['app_name']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		$google_creds['client_id'] = $this->ask('Client ID? ');			
		if($google_creds['client_id']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		$google_creds['client_secret'] = $this->ask('Client secret? ');			
		if($google_creds['client_secret']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		$google_creds['redirect_uri'] = $this->ask('Redirect URI? ');			
		if($google_creds['redirect_uri']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		$google_creds['scopes'] = $this->ask('Scopes? ');			
		if($google_creds['scopes']) { 
			//$this->line(var_export($google_creds)."\n");
		}

		return $google_creds;
	}


	// ------------------------------------------------------------------------
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		
		
		$this->comment("\n*******************************");
		$this->comment('Setting up Laravel Starter Site');
		$this->comment("*******************************\n");

        // google creds
        if($this->confirm('Use Google+ Auth? [yes|no]', true)) {

        	$google_creds = Config::get('google-config');
        	$this->line("\n");
			if($this->confirm("Enter local Google credentials? [yes|no]", true)) {
				$google_creds['local'] = $this->createGoogleCredentials();
			}
			$this->line("\n");
			if($this->confirm("Enter remote Google credentials? [yes|no]", true)) {
				$google_creds['remote'] = $this->createGoogleCredentials();
			}

			ConfigHelper::setAndSaveConfigFile("google-config.php", null, $google_creds);
			$this->comment("Current Local Google+ Settings:");
			foreach ($google_creds['local'] as $key => $value) {
				$this->line("{$key} = {$value}");
			}
			$this->comment("Current Remote Google+ Settings:");
			foreach ($google_creds['remote'] as $key => $value) {
				$this->line("{$key} = {$value}");
			}

			

			// ConfigHelper::setAndSave('google-config.local', $google_creds['local'], 'production');
			// ConfigHelper::setAndSave('google-config.remote', $google_creds['remote'], 'production');

        }
         
		 // create a admin user?
        if($this->confirm('Setup local database credentials? [yes|no]', true)) {
			
			$local_db_path = 'database.connections.mysql';
			$creds = Config::get($local_db_path); // default data

			$this->comment("Current Local Settings:");
			foreach ($creds as $key => $value) {
				$this->line("{$key} = {$value}");
			}

			


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

			$host = $this->ask("Hostname? ");			
			if($host) { 
				$creds['host'] = $host;
			}


			$database = $this->ask('Database name? ');			
			if($database) { 
				$creds['database'] = $database;
			}

			$username = $this->ask('Database username? ');			
			if($username) { 
				$creds['username'] = $username;
			}

			$password = $this->ask('Database password? ');			
			if($password) { 
				$creds['password'] = $password;
			}

			$prefix = $this->ask('Database prefix? ');			
			if($prefix) { 
				$creds['prefix'] = $prefix;
			}
			else {
				$this->comment("If you do not set a prefix you may run into foriegn key conflics.");
				$prefix = $this->ask('Database prefix? ');			
				if($prefix) { 
					$creds['prefix'] = $prefix;
				}
			}


			$this->comment("\n*******************************");
			$this->comment("   Local Database Credentials    ");
			$this->comment("*******************************");
			foreach ($creds as $key => $value) {
				$this->line("{$key} = {$value}");
			}

			$t = ConfigHelper::setAndSaveConfigFile("local/database.php", 'connections.mysql', $creds);
			Config::set("database.connections.mysql", $creds);
			DB::connection("mysql");
						
        }


        

		 // create a admin user?
        if($this->confirm('Migrate the database? [yes|no]', true)) {
			$this->comment("\nMigrating the database...\n");        	
			$this->migrateTheDatabase();
        }

		$sitename = $this->option('sitename');

		if( $sitename == NULL) {
			$sitename = $this->ask('What is the name of this site? ');
			if($sitename) {
				Config::set('config.site-name', $sitename);
				ConfigHelper::save('config', 'production');				
			}
		}
		$sitename = empty($sitename)?'Laravel Starter Site' : $sitename;
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
        	$this->call('site:adduser', array('--admin' => 'yes'));
        }

		$this->comment("\n*******************************");
		$this->comment('          All Done!			');
		$this->comment("*******************************\n");

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
			// array('reset', InputArgument::OPTIONAL, 'Reset the site.', null)
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return array(
			array('sitename', null, InputOption::VALUE_OPTIONAL, 'Name of this site.', null),
		);
	}

}
