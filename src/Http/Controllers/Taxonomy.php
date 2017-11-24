<?php

namespace TapestryCloud\Api\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\ClassificationTransformer;
use TapestryCloud\Api\Transformers\TaxonomyTransformer;
use TapestryCloud\Database\Entities\Taxonomy as TaxonomyModel;

class Taxonomy extends Controller
{

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var TaxonomyModel $record */
        if (! $record = $this->entityManager->getRepository(TaxonomyModel::class)->find($args['taxonomy_id'])){
            return $response->withStatus(404);
        }

        $resource = new Item($record, new TaxonomyTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    public function classifications(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var TaxonomyModel $record */
        if (! $record = $this->entityManager->getRepository(TaxonomyModel::class)->find($args['taxonomy_id'])){
            return $response->withStatus(404);
        }

        $resource = new Collection($record->getClassifications(), new ClassificationTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }
}