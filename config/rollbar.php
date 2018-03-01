<?php

return [
	'rollbar' => [
    	'access_token' 				=> env('ROLLBAR_TOKEN'),
    	'level' 					=> 'info',
    	'enable_utf8_sanitization'  => false,
    	'code_version'				=> env('VERSION_TAG', 'latest'),
    	'environment'				=> env('EJ_ENV', env('API_ENV'), env('APP_ENV')) ?? 'production',
	],
];
