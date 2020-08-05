<?php
namespace Gw\Oauth2Client;

use Gw\Oauth2Client\Client;

class AccessToken implements \ArrayAccess
{
	protected $attributes;
	
	protected $client;
	
	public function __construct(array $attributes,Client $client)
	{
		$this->client = $client;
		$this->attributes = $attributes;
	}
	
	/**
	 * @param offset
	 */
	public function offsetExists ($offset) {
		return isset($this->attributes[$offset]);
	}

	/**
	 * @param offset
	 */
	public function offsetGet ($offset) {
		return $this->attributes[$offset];
	}

	/**
	 * @param offset
	 * @param value
	 */
	public function offsetSet ($offset, $value) {
		$this->attributes[$offset] = $value;
	}

	/**
	 * @param offset
	 */
	public function offsetUnset ($offset) {
		unset($this->attributes[$offset]);
	}
	
	public function refresh()
	{
		return $this->client->callGrant('refresh_token');
	}
	
	public function __get($key)
	{
		return $this->attributes[$key];
	}
	
	public function __set($key,$value)
	{
		$this->attributes[$key] = $value;
	}
}