<?php
namespace Gw\Oauth2Client\Resource;

use Gw\Oauth2Client\Resource\ResourceInterface;
use Gw\Oauth2Client\Client;

/**
 * 部分resource没有对post、put、delete操作进行支持，可以在子类覆盖对应的方法为空实现来防止调用
 *
 */
abstract class ResourceAbstract implements ResourceInterface
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
	 * 创建uri
	 * @return string
	 */
	public function makeUri($action = null)
	{
		return $this->client->config['resource_uri'].'/'.$this->getIdentifier().(isset($action) ? '/'.$action : '');
	}
	
	/**
	 * 创建带id的uri
	 * @param number $id
	 * @return string
	 */
	public function makeUriWithId($action = null, $id)
	{
		return $this->makeUri($action).'/'.$id;
	}
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Resource\ResourceInterface::get()
	 */
	public function get($action = null, $id = null,array $params = [])
	{
		if (!is_null($id))
		{
			$uri = $this->makeUriWithId($action, $id);
		}
		else 
		{
			$uri = $this->makeUri($action);
		}
		$params['access_token'] = $this->client->accessToken()->access_token;
		return $this->_request($uri,$params);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Resource\ResourceInterface::post()
	 */
	public function post($action = null, array $params)
	{
		$params['access_token'] = $this->client->accessToken()->access_token;
		return $this->_request($this->makeUri($action),$params,'post');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Resource\ResourceInterface::put()
	 */
	public function put($action = null, $id,array $params)
	{
		$uri = $this->makeUriWithId($action, $id);
		$params['access_token'] = $this->client->accessToken()->access_token;
		return $this->_request($uri,$params,'put');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Gw\Oauth2Client\Resource\ResourceInterface::delete()
	 */
	public function delete($action = null, $id)
	{
		$params['access_token'] = $this->client->accessToken()->access_token;
		return $this->_request($this->makeUriWithId($action, $id),$params,'delete');
	}

	public function request($action = null, $params, $token, $method)
	{
		$params['access_token'] = $token;
		return $this->_request($this->makeUri($action), $params, $method);
	}
	
	/**
	 * 发送http请求
	 * @param string $uri
	 * @param array $params
	 * @param string $method
	 */
	protected function _request($uri,array $params = [],$method = 'get')
	{
		$response = $this->curl->$method($uri,$params);
		return $response->body;
	}
}