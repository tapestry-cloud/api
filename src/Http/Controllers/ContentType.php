<?php

namespace TapestryCloud\Api\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\ContentTypeTransformer;
use TapestryCloud\Api\Transformers\FileTransformer;
use TapestryCloud\Api\Transformers\TaxonomyTransformer;

class ContentType extends Controller
{

    /**
     * /content-types
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $resource = new Collection(
            $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)
                ->findAll(),
            new ContentTypeTransformer()
        );

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));
        return $response;
    }

    /**
     * /content-type/{id}/
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface|static
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\ContentType $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)->find($args['content_type_id'])) {
            return $response->withStatus(404);
        }

        $resource = new Item($record, new ContentTypeTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    /**
     * /content-type/{id}/taxonomy
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function taxonomy (ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\ContentType $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)->find($args['content_type_id'])) {
            return $response->withStatus(404);
        }

        $resource = new Collection($record->getTaxonomy(), new TaxonomyTransformer());

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));
        return $response;
    }

    /**
     * /content-type/{id}/files
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function files (ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\ContentType $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\ContentType::class)->find($args['content_type_id'])) {
            return $response->withStatus(404);
        }

        $resource = new Collection($record->getFiles(), new FileTransformer());
        $query = $request->getQueryParams();

        $this->manager->parseIncludes(isset($query['include']) ? $query['include'] : []);

        $response->getBody()->write(json_encode(
            array_merge([
                'links' => [
                    [
                        'rel' => 'self',
                        'uri' => apiUri('/content-type/' . $record->getId() . '/files')
                    ],
                    [
                        'rel' => 'withFrontmatter',
                        'uri' => apiUri('/content-type/' . $record->getId() . '/files?include=frontmatter')
                    ]
                ]
            ],$this->manager->createData($resource)->toArray())
        ));
        return $response;
    }
}
