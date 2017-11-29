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
use TapestryCloud\Database\Entities\Taxonomy as TaxonomyModel;
use TapestryCloud\Database\Entities\Classification as ClassificationModel;
use TapestryCloud\Database\Repositories\ClassificationRepository;

class Classification extends Controller
{
    /**
     * /classification
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $resource = new Collection(
            $this->entityManager->getRepository(ClassificationModel::class)
                ->findAll(),
            new ClassificationTransformer()
        );

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));
        return $response;
    }

    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var ClassificationModel $record */
        if (! $record = $this->entityManager->getRepository(ClassificationModel::class)->find($args['classification_id'])){
            return $response->withStatus(404);
        }

        $resource = new Item($record, new ClassificationTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    public function taxonomy(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var ClassificationModel $record */
        if (! $record = $this->entityManager->getRepository(ClassificationModel::class)->find($args['classification_id'])){
            return $response->withStatus(404);
        }

        $resource = new Collection($record->getTaxonomy(), new TaxonomyTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    public function files(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var ClassificationModel $record */
        if (! $record = $this->entityManager->getRepository(ClassificationModel::class)->find($args['classification_id'])){
            return $response->withStatus(404);
        }

        $resource = new Collection($record->getFiles(), new FileTransformer());

        $this->manager->parseIncludes(['frontmatter']);

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }
}