<?php

namespace TapestryCloud\Api\Http\Controllers;

use Doctrine\ORM\EntityRepository;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\ClassificationTransformer;
use TapestryCloud\Api\Transformers\FileTransformer;
use TapestryCloud\Api\Transformers\TaxonomyTransformer;
use TapestryCloud\Database\Entities\Classification;
use TapestryCloud\Database\Entities\Taxonomy as TaxonomyModel;
use TapestryCloud\Database\Entities\Classification as ClassificationModel;
use TapestryCloud\Database\Repositories\ClassificationRepository;

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

        $resource = new Collection($record->getClassifications(), new ClassificationTransformer($record));

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    public function files(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var TaxonomyModel $taxonomy */
        if (! $taxonomy = $this->entityManager->getRepository(TaxonomyModel::class)->find($args['taxonomy_id'])){
            return $response->withStatus(404);
        }

        /** @var EntityRepository|ClassificationRepository $repo */
        $repo = $this->entityManager->getRepository(Classification::class);

        if (! $files = $repo->findFilesByContentType($taxonomy->getContentType()->getId(), $args['classification_id'])){
            return $response->withStatus(404);
        }

        $resource = new Collection($files, new FileTransformer());

        $this->manager->parseIncludes(['frontmatter']);

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

}