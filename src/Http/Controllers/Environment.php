<?php

namespace TapestryCloud\Api\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\EnvironmentTransformer;
use TapestryCloud\Database\Entities\Environment as EnvironmentModel;

class Environment extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $resource = new Collection(
            $this->entityManager->getRepository(EnvironmentModel::class)->findAll(),
            new EnvironmentTransformer()
        );

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        if (! $record = $this->entityManager->getRepository(EnvironmentModel::class)->find($args['environment_id'])){
            return $response->withStatus(404);
        }

        $resource = new Item($record, new EnvironmentTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }
}