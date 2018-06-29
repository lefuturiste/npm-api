<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use Httper\Request;
use Httper\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Validator\Validator;

class PackageController extends Controller
{
    public function getSearch(ServerRequestInterface $request, ResponseInterface $response)
    {
        $validator = new Validator($request->getQueryParams());
        $validator->required('query');
        $validator->notEmpty('query');
        if ($validator->isValid()) {
            $queryParams = "?q={$validator->getValue('query')}";
            if ($validator->getValue('page') !== NULL && $validator->getValue('perPage') !== NULL && !empty($validator->getValue('page')) && !empty($validator->getValue('perPage'))) {
                $queryParams .= "&page={$validator->getValue('page')}&perPage={$validator->getValue('perPage')}";
            }
            if ($validator->getValue('ranking') !== NULL && !empty($validator->getValue('ranking'))) {
                $queryParams .= "&ranking={$validator->getValue('ranking')}";
            }
            $client = new \Httper\Client();
            try {
                $searchResponse = $client->request((new Request())
                    ->withUri(new Uri($this->container->get('npm')['endpoint'] . "/search" . $queryParams))
                    ->withHeader('x-spiferack', true)
                );
            } catch (\Exception $e) {
                return $response->withJson([
                    'success' => false
                ])->withStatus($e->getCode());
            }

            $packages = json_decode($searchResponse->getBody()->getContents(), 1)['objects'];

            return $response->withJson([
                'success' => true,
                'data' => [
                    'count' => count($packages),
                    'packages' => $packages
                ]
            ]);
        } else {
            return $response->withJson([
                'success' => false,
                'errors' => $validator->getErrors()
            ]);
        }
    }

    public function getPackage($packageName, ServerRequestInterface $request, ResponseInterface $response)
    {
        $client = new Client();
        try {
            $packageResponse = $client->get($this->container->get('npm')['endpoint'] . "/package/{$packageName}", [
                'headers' => [
                    'x-spiferack' => true
                ]
            ]);
        } catch (\Exception $e) {
            return $response->withJson([
                'success' => false
            ])->withStatus($e->getCode());
        }
        $package = json_decode($packageResponse->getBody(), 1);

        return $response->withJson([
            'success' => true,
            'data' => $package
        ]);
    }
}
