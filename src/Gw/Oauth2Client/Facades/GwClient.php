<?php 
namespace Gw\Oauth2Client\Facades;

use Illuminate\Support\Facades\Facade;

class GwClient extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'gw_client'; }

}
