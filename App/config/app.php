<?php
return [
	'app_name' => getenv('APP_NAME'),
	'app_debug' => (envOrDefault('APP_DEBUG', 0) ? true : false),
	'env_name' => getenv('APP_ENV_NAME')
];
