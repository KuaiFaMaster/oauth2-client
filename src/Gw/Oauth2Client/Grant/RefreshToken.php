<?php
namespace Gw\Oauth2Client;

use Gw\Oauth2Client\Grant\GrantTypeAbstract;

class RefreshToken extends GrantTypeAbstract
{
	protected $identifier = 'refresh_token';
	
	public function call()
	{
		
	}
}