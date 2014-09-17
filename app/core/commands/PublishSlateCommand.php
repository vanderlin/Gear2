<?php namespace core\commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PublishSlateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'slate:publish';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish assets and configuration';

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
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		if($this->confirm('Are you sure you want to publish config/assets? |yes|no|')) {
			$this->call('config:publish', ['package'=>'vanderlin/slate', '--path'=>'app/core/config']);
	        $this->info( "publishing complete!" );
    	}
    	if($this->confirm('Are you sure you want to publish views? |yes|no|')) {
			$this->call('view:publish', ['package'=>'vanderlin/slate', '--path'=>'app/core/views']);
	        $this->info( "publishing complete!" );
    	}
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
