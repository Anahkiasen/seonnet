<?php namespace Seonnet;

use Illuminate\Support\ServiceProvider;

class SeonnetServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSeonnet();
		$this->registerCommands();
	}

	protected function registerSeonnet()
	{

		$app = $this->app;

		// Bind database to the Model
		Route::setConnectionResolver($app->db);

		$this->app->bind('seonnet', function($app) {
			return new Seonnet($app);
		});

		$this->app->singleton('seonnet.router', function($app) {
			return new Router($app);
		});

	}

	/**
	 * Register Seonnet's commands
	 */
	protected function registerCommands()
	{
		$app = $this->app;

		$app['command.seonnet.database'] = $app->share(function($app)
		{
			return new Console\MakeTableCommand($app['files']);
		});

		$this->commands('command.seonnet.database');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}