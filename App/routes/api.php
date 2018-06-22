<?php
/*
|--------------------------------------------------------------------------
| Api routing
|--------------------------------------------------------------------------
|
| Register it all your api routes
|
*/
$app->get('/', [\App\Controllers\PagesController::class, 'getHome']);
$app->get('/search', [\App\Controllers\PackageController::class, 'getSearch']);
$app->get('/package/{packageName}', [\App\Controllers\PackageController::class, 'getPackage']);
$app->add(new \App\Middlewares\CorsMiddleware());
