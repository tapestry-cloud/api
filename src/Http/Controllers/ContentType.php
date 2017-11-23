<?php

namespace TapestryCloud\Api\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Api\ContentTypeCollection;

class ContentType extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $resource = (new ContentTypeCollection())
            ->getIndexResource(
                $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)
                    ->findBy(['environment' => $args['environment_id']]));


        $response->getBody()->write(json_encode(
            array_merge([
                'parent' => '/environment/' . $args['environment_id']
            ], $this->manager->createData($resource)->toArray())
        ));
        return $response;
    }

    public function taxonomies(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\ContentType $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)->findOneBy(['name' => $args['content_type_id']])) {
            return $response->withStatus(404);
        }

        $resource = (new ContentTypeCollection())
            ->getTaxonomiesResource($record);

        $response->getBody()->write(json_encode(
            array_merge([
                'parent' => '/content-types/' . $record->getName()
            ], $this->manager->createData($resource)->toArray())
        ));
        return $response;
    }

}
