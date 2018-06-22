<?php

use Psr\Container\ContainerInterface;

return [
	'settings.displayErrorDetails' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},
	'settings.debug' => function (ContainerInterface $container) {
		return $container->get('app_debug');
	},

	'notFoundHandler' => function (ContainerInterface $container) {
		return new \App\NotFoundHandler();
	}
];
