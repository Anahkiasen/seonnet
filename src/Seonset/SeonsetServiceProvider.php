<?php namespace Seonset;

use Illuminate\Support\ServiceProvider;

class SeonsetServiceProvider extends ServiceProvider {

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
		$this->registerCommands();
	}

	/**
	 * Register Seonset's commands
	 */
	protected function registerCommands()
	{
		$app = $this->app;

		$app['command.seonset.database'] = $app->share(function($app)
		{
			return new Console\MakeTableCommand($app['files']);
		});

		$this->commands('command.seonset.database');
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