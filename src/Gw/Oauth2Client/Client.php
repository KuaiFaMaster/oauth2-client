<?php
namespace Gw\Oauth2Client;

use Gw\Oauth2Client\Grant\GrantTypeInterface;
use Gw\Oauth2Client\Resource\ResourceInterface;
use Gw\Oauth2Client\AccessToken;
use Illuminate\Support\Collection;

/**
 * 
 * @author 星の在り処
 *
 */
class Client
{	
	/**
	 * 
	 * @var array
	 */
	public $config;
	
	/**
	 * 
	 * @var Collection
	 */
	protected $grant_types;
	
	/**
	 * 
	 * @var Collection
	 */
	protected $resources;
	
	/**
	 * 
	 * @var string
	 */
	protected $host;
	
	/**
	 * 
	 * @var AccessToken
	 */
	protected $access_token;
	
	
	/**
	 * 
	 * @param array $config
	 * @param Collection $grant_types
	 * @param Collection $resources
	 */
	public function __construct(array $config,Collection $grant_types,Collection $resources)
	{
		$this->config = $config;
		$this->grant_types = $grant_types;
		$this->resources = $resources;
	}
	
	/**
	 * 设置access_token
	 * @param AccessToken $access_token
	 */
	public function setAccessToken(AccessToken $access_token)
	{
		$this->access_token = $access_token;
		\Session::put('_access_token',$this->access_token);
	}
	
	/**
	 * 注册grant
	 * @param GrantTypeInterface $grant
	 */
	public function addGrantType(GrantTypeInterface $grant)
	{
		$this->grant_types->put($grant->getIdentifier(), $grant);
	}
	
	/**
	 * 获取已注册grant
	 * @param string $identifier
	 * @throws \Exception
	 */
	public function getGrantType($identifier)
	{
		if ($this->grant_types->has($identifier))
		{
			return $this->grant_types->get($identifier);
		}
		
		throw new \Exception('GrantType '.$identifier.' Not Found');
	}
	
	/**
	 * 设定grant_type集合
	 * @param Collection $collection
	 */
	public function setGrantTypes(Collection $collection)
	{
		$this->grant_types = $collection;
	}
	
	/**
	 * 调用grant
	 * @param string $identifier
	 * @param array $params
	 * @return string
	 */
	public function callGrant($identifier,array $params = [])
	{
		$response =  $this->getGrantType($identifier)->call($params);
		return $response;	
	}
	
	/**
	 * 跳转到认证页
	 * @return Redirect
	 */
	public function authorize()
	{		
		$param = [
			'client_id' => $this->config['app']['client_id'],
			'redirect_uri' => $this->config['app']['redirect_uri'],
			'response_type' => $this->config['app']['response_type'],
			'scope' => $this->config['app']['scope'],
		];
			
		$uri = $this->config['domain'].'/authorize?'.http_build_query($param);
		return \Redirect::to($uri);
	}
	
	/**
	 * 获取access_token
	 * @param AccessToken
	 */
	public function accessToken()
	{
		if (!$this->access_token)
		{
			$this->access_token = \Session::get('_access_token');
		}
		return $this->access_token;
	}
	
	/**
	 * 注册资源
	 * @param ResourceInterface $resource
	 */
	public function addResource(ResourceInterface $resource)
	{
		$this->resources->put($resource->getIdentifier(),$resource);
	}
	
	/**
	 * 获取已注册资源
	 * @param ResourceInterface $identifier
	 * @throws \Exception
	 */
	public function getResource($identifier)
	{
		if ($this->resources->has($identifier))
		{
			return $this->resources->get($identifier);
		}
		
		throw new \Exception('Resource '.$identifier.' Not Found');
	}
	
	/**
	 * 设定resource集合
	 * @param Collection $collection
	 */
	public function setResources(Collection $collection)
	{
		$this->resources = $collection;
	}

}