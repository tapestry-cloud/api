<?php

include '../vendor/autoload.php';

$app = new \TapestryCloud\Api\App();

//
// Services
//

$app->register(new \TapestryCloud\Api\Services\Configuration);
$app->register(new \TapestryCloud\Api\Services\Tapestry);
$app->register(new \TapestryCloud\Database\ServiceProvider);

//
// Routes
//

$app->getRouter()->setStrategy(new \League\Route\Strategy\JsonStrategy);

$app->get('/', function(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response){
    $response->getBody()->write(json_encode([
        'message' => 'Tapestry API'
    ]));
    return $response;
});

// Remove environment stuff...
$app->get('/environments', '\TapestryCloud\Api\Http\Controllers\Environment::index');
$app->get('/environment/{environment_id}', '\TapestryCloud\Api\Http\Controllers\Environment::view');

$app->get('/taxonomy/{taxonomy_id}', '\TapestryCloud\Api\Http\Controllers\Taxonomy::view');
$app->get('/taxonomy/{taxonomy_id}/classifications', '\TapestryCloud\Api\Http\Controllers\Taxonomy::classifications');

$app->get('/content-types', '\TapestryCloud\Api\Http\Controllers\ContentType::index');
$app->get('/content-type/{content_type_id}', '\TapestryCloud\Api\Http\Controllers\ContentType::view');

// @todo the below with a File and Taxonomy controller
$app->get('/content-type/{content_type_id}/taxonomy', '\TapestryCloud\Api\Http\Controllers\ContentType::taxonomy');
$app->get('/content-type/{content_type_id}/files', '\TapestryCloud\Api\Http\Controllers\ContentType::files');

return $app;