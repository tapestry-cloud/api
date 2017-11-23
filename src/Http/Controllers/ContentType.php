<?php

namespace TapestryCloud\Api\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\ContentTypeTransformer;

class ContentType extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $resource = new Collection(
            $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)
                ->findBy(['environment' => $args['environment_id']]),
            new ContentTypeTransformer()
        );

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));
        return $response;
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\ContentType $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)->findOneBy(['name' => $args['content_type_id']])) {
            return $response->withStatus(404);
        }

        $resource = new Item($record, new ContentTypeTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }
}
