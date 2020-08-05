<?php
namespace Gw\Oauth2Client\Grant;

use Gw\Oauth2Client\Grant\GrantTypeAbstract;
use Gw\Oauth2Client\AccessToken;

class AuthorizationCode extends GrantTypeAbstract
{
	protected $identifier = 'authorization_code';
	
	public function call(array $params)
	{
		if (!isset($params['code']) || !$params['code'])
		{
			\App::abort(404,'Invalid callback');
		}
		
		$response = parent::call($params);
		
		$json = json_decode($response,1);
		
		if (isset($json['access_token']))
		{
			$this->client->setAccessToken(new AccessToken($json,$this->client));
		}
		return $response;
	}
}