<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PackageController extends Controller
{
	public function getSearch(ServerRequestInterface $request, ResponseInterface $response)
	{
    $validator = new \Validator\Validator($request->getQueryParams());
    $validator->required('query');
    $validator->notEmpty('query');
		if ($validator->isValid()) {
      $client = new \GuzzleHttp\Client();
      $queryParams = "?q={$validator->getValue('query')}";
      if ($validator->getValue('page') !== NULL && $validator->getValue('perPage') !== NULL && !empty($validator->getValue('page')) && !empty($validator->getValue('perPage'))) {
        $queryParams .= "&page={$validator->getValue('page')}&perPage={$validator->getValue('perPage')}";
      }
      if ($validator->getValue('ranking') !== NULL && !empty($validator->getValue('ranking'))) {
        $queryParams .= "&ranking={$validator->getValue('ranking')}";
      }
      $searchResponse = $client->get($this->container->get('npm')['endpoint'] . "/search" . $queryParams, [
        'headers'=> [
          'x-spiferack' => true
        ]
      ]);

      $packages = json_decode($searchResponse->getBody(), 1)['objects'];
      return $response->withJson([
        'success' => true,
        'data' => [
          'count' => count($packages),
          'packages' => $packages
        ]
      ]);
    }else{
      return $response->withJson([
        'success' => false,
        'errors' => $validator->getErrors()
      ]);
    }
	}

  public function getPackage($packageName, ServerRequestInterface $request, ResponseInterface $response)
  {
    $client = new \GuzzleHttp\Client();
    try {
      $packageResponse = $client->get($this->container->get('npm')['endpoint'] . "/package/{$packageName}", [
        'headers'=> [
          'x-spiferack' => true
        ]
      ]);
      $package = json_decode($packageResponse->getBody(), 1);
      return $response->withJson([
        'success' => true,
        'data' => $package
      ]);
    } catch (\Exception $e) {
      return $response->withJson([
        'success' => false
      ])->withStatus($e->getCode());
    }

  }
}
