<?php

namespace TapestryCloud\Api\Services;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use TapestryCloud\Api\App;

class Routes extends AbstractServiceProvider implements BootableServiceProviderInterface
{

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        // ...
    }

    /**
     * Method will be invoked on registration of a service provider implementing
     * this interface. Provides ability for eager loading of Service Providers.
     *
     * @return void
     */
    public function boot()
    {
        /** @var App $app */
        $app = $this->getContainer()->get(App::class);

        $app->getRouter()->setStrategy(new \League\Route\Strategy\JsonStrategy);

        $app->get('/', function(\Psr\Http\Message\RequestInterface $request, \Psr\Http\Message\ResponseInterface $response){
            $response->getBody()->write(json_encode([
                'message' => 'Tapestry API'
            ]));
            return $response;
        });

        //
        // Files
        //
        $app->get('/files', '\TapestryCloud\Api\Http\Controllers\File::index');
        $app->get('/file/{file_id}', '\TapestryCloud\Api\Http\Controllers\File::view');

        //
        // Taxonomy
        //
        $app->get('/taxonomy/{taxonomy_id}', '\TapestryCloud\Api\Http\Controllers\Taxonomy::view');
        $app->get('/taxonomy/{taxonomy_id}/classifications', '\TapestryCloud\Api\Http\Controllers\Taxonomy::classifications');
        $app->get('/taxonomy/{taxonomy_id}/classification/{classification_id}/files', '\TapestryCloud\Api\Http\Controllers\Taxonomy::files');

        //
        // Content Types
        //
        $app->get('/content-types', '\TapestryCloud\Api\Http\Controllers\ContentType::index');
        $app->get('/content-type/{content_type_id}', '\TapestryCloud\Api\Http\Controllers\ContentType::view');

        // @todo the below with a File and Taxonomy controller
        $app->get('/content-type/{content_type_id}/taxonomy', '\TapestryCloud\Api\Http\Controllers\ContentType::taxonomy');
        $app->get('/content-type/{content_type_id}/files', '\TapestryCloud\Api\Http\Controllers\ContentType::files');
    }
}