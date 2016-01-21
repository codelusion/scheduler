<?php

require __DIR__.'/../src/bootstrap.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', function (Request $request, Response $response) use($app) {
    return new JsonResponse($app['userRepository']->findAll());
});

$app->get('/hello/{name}', function ($request, $response, $args) {
    return new JsonResponse( ['hello' => $args['name']]);
});

$app->run();