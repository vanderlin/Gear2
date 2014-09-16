<?php namespace Vanderlin\Slate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;

class SlateServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot() {
		// 	$loader = $this->app['config']->getLoader();
		// $configs = $loader->load($this->app['config']->getEnvironment(),'config','slate');
		// // $this->app['config']->set('slate::config.debug', $configs->debug);
		// $this->app['config']->set('app.debug',$configs['app']['debug']);
		//Config::set('app.debug', true);
		
	}

	// ------------------------------------------------------------------------
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {


		$this->package('vanderlin/slate', 'slate', __DIR__);
		//Config::package('vanderlin/slate', __DIR__.'/config', 'slate');

		/*echo "<pre>";
		print_r(Config::get('slate::site-name'));
		echo "</pre>";
		dd('');*/
        AliasLoader::getInstance()->alias('Asset', 'Vanderlin\Slate\Asset');
        AliasLoader::getInstance()->alias('Permission', 'Vanderlin\Slate\Permission');
        AliasLoader::getInstance()->alias('Role', 'Vanderlin\Slate\Role');
        AliasLoader::getInstance()->alias('Theme', 'Vanderlin\Slate\Theme');
        AliasLoader::getInstance()->alias('User', 'Vanderlin\Slate\User');
        AliasLoader::getInstance()->alias('UserRepository', 'Vanderlin\Slate\UserRepository');
        AliasLoader::getInstance()->alias('ConfigHelper', 'Vanderlin\Slate\Helpers\ConfigHelper');


		//AliasLoader::getInstance()->alias('Confide', 'Zizaco\Confide\Facade');	
        
		View::addNamespace('slate', __DIR__."/Views");
		Config::addNamespace('slate', __DIR__.'/Config');

		$this->app['config']->package('vanderlin/slate', __DIR__.'/Config');

		//dd('');



		// 'Confide'    => 'Zizaco\Confide\Facade',
		//$this->app['config']->set('app.debug', true);
		// $this->app['config'] = $this->app->bind(function($app) {
  //           return 'ttt';
  //       });
        		// dd($this->app['config']->get('app.debug'));

		/*
		// Get config loader
		$loader = $this->app['config']->getLoader();

		// Add package namespace with path set base on your requirement
		$loader->addNamespace('basset',__DIR__.'/../config/basset');

		// Load package override config file
		$configs = $loader->load($this->app['config']->getEnvironment(),'config','basset');

		// Override value
		$this->app['config']->set('basset::config',$configs);
		*/
	
		//Config::set('*::app.debug', Config::get('slate::debug'));

		// echo "<pre>";
		// print_r($this->app['config']);
		// echo "</pre>";
		// dd('');

        // $this->app['slate.user.repository'] = $this->app->share(function($app) {
        //     return new UserRepository;
        // });

        

        // // $this->app['slate.theme'] = $this->app->share(function($app) {
        // //     return new Theme;
        // // });


		$this->setCommands();
		$this->setConnection();


	    include __DIR__.'/../../routes.php';

	}


	// ------------------------------------------------------------------------
	public function setCommands() {

		$this->app['slate.reset'] = $this->app->share(function($app) {
            return new Commands\ResetSiteCommand;
        });
        $this->commands('slate.reset');

        $this->app['slate.setup'] = $this->app->share(function($app) {
            return new Commands\SiteSetupCommand;
        });
        $this->commands('slate.setup');

        $this->app['slate.adduser'] = $this->app->share(function($app) {
            return new Commands\UserGeneratorCommand;
        });
        $this->commands('slate.adduser');

       	$this->app['slate.publish'] = $this->app->share(function($app) {
            return new Commands\PublishSlateCommand;
        });
        $this->commands('slate.publish');

       	$this->app['slate.migrate'] = $this->app->share(function($app) {
            return new Commands\MigrateSlateCommand;
        });
        $this->commands('slate.migrate');
	}

	// ------------------------------------------------------------------------
	public function setConnection() {

	    $connection = Config::get('slate::database.connections');
	    Config::set('database.connections', $connection);
	}

	// ------------------------------------------------------------------------
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('slate');
	}

}
