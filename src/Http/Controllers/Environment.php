<?php

namespace TapestryCloud\Api\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Api\EnvironmentCollection;

class Environment extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $resource = (new EnvironmentCollection())
            ->getIndexResource(
                $this->entityManager->getRepository(\TapestryCloud\Database\Entities\Environment::class)
                    ->findAll());

        $response->getBody()->write(json_encode([
            'ok' => true,
            'data' => $this->manager->createData($resource)->toArray()
        ]));
        return $response;
    }
}