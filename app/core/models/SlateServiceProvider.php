<?php namespace core\models;

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


		$this->package('vanderlin/slate', 'slate', app_path()."/core");

		// Alias
		// AliasLoader::getInstance()->alias('Asset', 'core\models\Asset');
        AliasLoader::getInstance()->alias('Permission', 'core\models\Permission');
        AliasLoader::getInstance()->alias('Role', 'core\models\Role');
        AliasLoader::getInstance()->alias('Theme', 'core\models\Theme');
        // AliasLoader::getInstance()->alias('User', 'core\models\User');
        AliasLoader::getInstance()->alias('UserRepository', 'core\models\UserRepository');
        AliasLoader::getInstance()->alias('ConfigHelper', 'core\helpers\ConfigHelper');

		
        

		//View::addNamespace('slate', 'slate', app_path()."/core/views");


		/*
        
*/

		//AliasLoader::getInstance()->alias('Confide', 'Zizaco\Confide\Facade');	
        
		// View::addNamespace('slate', __DIR__."../views");
		// Config::addNamespace('slate', __DIR__.'/Config');

		// $this->app['config']->package('vanderlin/slate', __DIR__.'/Config');



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


	    include __DIR__.'/../routes.php';

	}


	// ------------------------------------------------------------------------
	public function setCommands() {

		$this->app['slate.reset'] = $this->app->share(function($app) {
            return new \core\commands\ResetSiteCommand;
        });
        $this->commands('slate.reset');

        $this->app['slate.setup'] = $this->app->share(function($app) {
            return new \core\commands\SiteSetupCommand;
        });
        $this->commands('slate.setup');

        $this->app['slate.adduser'] = $this->app->share(function($app) {
            return new \core\commands\UserGeneratorCommand;
        });
        $this->commands('slate.adduser');

       	$this->app['slate.publish'] = $this->app->share(function($app) {
            return new \core\commands\PublishSlateCommand;
        });
        $this->commands('slate.publish');

       	$this->app['slate.migrate'] = $this->app->share(function($app) {
            return new \core\commands\MigrateSlateCommand;
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
