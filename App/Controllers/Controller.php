<?php
namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Router;

class Controller{
	/**
	 * @var Router
	 */
	protected $router;

	/**
	 * @var Container
	 */
	protected $container;

	public function __construct(Router $router, Container $container)
	{
		$this->router = $router;
		$this->container = $container;
	}

	public function redirect(ResponseInterface $response, $location){
		return $response->withStatus(302)->withHeader('Location', $location);
	}

	public function pathFor($name, $params = []){
		return $this->router->pathFor($name, $params);
	}
}
