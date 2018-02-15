<?php

return [
	'rollbar' => [
    	'access_token' 				=> env('ROLLBAR_TOKEN'),
    	'level' 					=> 'info',
    	'enable_utf8_sanitization'  => false,
	],
];
