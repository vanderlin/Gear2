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

		// 'Confide'    => 'Zizaco\Confide\Facade',

		

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

		$this->app['site.reset'] = $this->app->share(function($app) {
            return new Commands\ResetSiteCommand;
        });
        $this->commands('site.reset');

        $this->app['site.setup'] = $this->app->share(function($app) {
            return new Commands\SiteSetupCommand;
        });
        $this->commands('site.setup');

        $this->app['site.adduser'] = $this->app->share(function($app) {
            return new Commands\UserGeneratorCommand;
        });
        $this->commands('site.adduser');
	}

	// ------------------------------------------------------------------------
	public function setConnection() {

	    $connection = Config::get('slate::local/database.connections');

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
