<?php
namespace Gw\Oauth2Client\Grant;

use Gw\Oauth2Client\Client;

interface GrantTypeInterface
{	
	/**
	 * 
	 * @param Client $client
	 */
	public function __construct(Client $client,\Curl $curl);
	
	/**
	 * @return string
	 */
	public function getIdentifier();
	
	/**
	 * 
	 * @param array $params
	 * @return string
	 */
	public function call(array $params);
}