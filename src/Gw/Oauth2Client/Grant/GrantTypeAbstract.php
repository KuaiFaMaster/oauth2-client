<?php
namespace Gw\Oauth2Client\Grant;

use Gw\Oauth2Client\Grant\GrantTypeInterface;
use Gw\Oauth2Client\Client;

abstract class GrantTypeAbstract implements GrantTypeInterface
{
	/**
	 * 
	 * @var \Curl
	 */
	protected $curl;
	
	/**
	 * 
	 * @var Client
	 */
	protected $client;
	
	/**
	 * 
	 * @var string
	 */
	protected $identifier;
	
	/**
	 * 
	 * @param Client $client
	 * @param \Curl $curl
	 */
	public function __construct(Client $client,\Curl $curl)
	{
		$this->client = $client;
		
		$this->curl = $curl;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Grant\GrantTypeInterface::getIdentifier()
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Grant\GrantTypeInterface::call()
	 */
	public function call(array $params)
	{		
		$url = $this->client->config['domain'].'/'.$this->client->config['auth_uri'];
		$params = array_merge($this->makeParams(),$params);
		$response = $this->curl->post($url,$params);
		
		return  $response->body;
	}
	
	/**
	 * @return array
	 */
	protected function commonParams()
	{
		$params = [
			'client_id' => $this->client->config['app']['client_id'],
			'redirect_uri' => $this->client->config['app']['redirect_uri'],
			'scope' => $this->client->config['app']['scope'],
			'client_secret' => $this->client->config['app']['client_secret']
		];
		return $params;
	}

	/**
	 * 
	 * @return array
	 */
	protected function makeParams()
	{
		$params = $this->commonParams();
		$params['grant_type'] = $this->getIdentifier();
		return $params;
	}
}