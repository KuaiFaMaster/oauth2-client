<?php 
namespace Gw\Oauth2Client;

use Illuminate\Support\ServiceProvider;
use Gw\Oauth2Client\Client;
use Illuminate\Support\Collection;

class ClientServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('gw/oauth2-client','gw/oauth2-client');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		if (!class_exists('\Curl'))
		{
			throw new \Exception('Package Curl not found,add the "shuber/curl": "dev-master" in your composer.json');
		}
		
		$this->app->bind('gw_client',function ($app)
		{
			$config = $app['config']->get('gw/oauth2-client::client');
			$client = new Client($config,new Collection(),new Collection());
			$curl = new \Curl();
			$curl->cookie_file = false;
			
			//注册grant
			foreach ($config['grant_types'] as $value)
			{
				if (isset($value['class']))
				{
					$client->addGrantType(new $value['class']($client,$curl));
				}
			}
			
			//注册资源
			foreach ($config['resouces'] as $value)
			{
				if (isset($value['class']))
				{
					$client->addResource(new $value['class']($client,$curl));
				}
			}
			
			return $client;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('gw_client');
	}

}
