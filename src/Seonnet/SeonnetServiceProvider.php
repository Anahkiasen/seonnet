<?php namespace Seonnet;

use Illuminate\Support\ServiceProvider;

class SeonnetServiceProvider extends ServiceProvider
{
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

	/**
	 * Register Seonnet's classes
	 *
	 * @return void
	 */
	protected function registerSeonnet()
	{
		$app = $this->app;

		// Bind database to the Model
		Route::setConnectionResolver($app->db);

		$this->app->bind('seonnet', function($app) {
			return new Seonnet($app, $app['router']);
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

		$app['command.seonnet.database'] = $app->share(function($app) {
			return new Console\MakeTableCommand($app['files']);
		});

		$this->commands('command.seonnet.database');
	}
}