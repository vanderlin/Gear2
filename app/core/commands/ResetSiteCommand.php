<?php namespace core\commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Schema;

class ResetSiteCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'slate:reset';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Delete all tables and reset to default';

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
	public function deleteAllTables() {
			
			Schema::dropIfExists('permission_role');
			Schema::dropIfExists('assigned_roles');
			Schema::dropIfExists('roles');
			Schema::dropIfExists('assets');
			Schema::dropIfExists('themes');
			
			Schema::dropIfExists('migrations');
			Schema::dropIfExists('password_reminders');
			Schema::dropIfExists('users');
			Schema::dropIfExists('permissions');

		
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		
		if($this->confirm('Are you sure you want to DELETE all tables in database? [yes|no]', true)) {
			$this->comment('*** DELETING ALL TABLES ***');
			$this->deleteAllTables();
		}

		return;
	
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			// array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			// array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
