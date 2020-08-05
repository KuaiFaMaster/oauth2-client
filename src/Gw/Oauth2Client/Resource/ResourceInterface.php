<?php
namespace Gw\Oauth2Client\Resource;

use Gw\Oauth2Client\Client;

/**
 * 
 * @author 星の在り処
 *
 */
interface ResourceInterface
{	
	/**
	 * 
	 * @param Client $client
	 */
	public function __construct(Client $client,\Curl $curl);
	
	/**
	 * 返回资源唯一标识
	 * @return string
	 */
	public function getIdentifier();
	
	/**
	 * 获取资源信息，传入id获取单个信息，为传入获取列表信息
	 * @param string|int $id
	 * @param array $params
	 */
	public function get($action = null, $id = null,array $params = []);

	/**
	 * 新增资源
	 * @param array $params
	 */
	public function post($action = null, array $params);
	
	/**
	 * 修改资源
	 * @param string|int $id
	 * @param array $params
	 */
	public function put($action = null, $id,array $params);
	
	/**
	 * 删除资源
	 * @param string|int $id
	 * @param array $params
	 */
	public function delete($action = null, $id);
}