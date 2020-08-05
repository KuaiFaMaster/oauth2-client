<?php
return [
	'app' => [
		'client_id' => '',
		'redirect_uri' => url('callback'),
		'response_type' => 'code',
		'scope' => 'account,game',
		'client_secret' => ''
	],

	'domain' => 'http://open.youxigongchang.com/oauth',
	'auth_uri' => 'access_token',
	'resource_uri' => 'http://open.youxigongchang.com/resources', 
	
	'grant_types' => [
		'authorization_code' => [
			'class' => 'Gw\Oauth2Client\Grant\AuthorizationCode'
		]
	],
	
	'resouces' => [
		'account' => [
			'class' => 'Gw\Oauth2Client\Resource\Account'
		],
		'game' => [
			'class' =>  'Gw\Oauth2Client\Resource\Game'
		]
	]
];