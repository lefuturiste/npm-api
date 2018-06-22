<?php

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CorsMiddleware{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
	{
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST, PUT, GET");
		header("Access-Control-Allow-Headers: Origin, Content-Type, Authorisation");
		return $next($request, $response);
	}
}