<?php

namespace TapestryCloud\Api\Http\Controllers;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TapestryCloud\Api\Transformers\FileTransformer;

class File extends Controller
{
    /**
     * /files.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $args
     *
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        $resource = new Collection(
            $this->entityManager->getRepository(\TapestryCloud\Database\Entities\File::class)
                ->findAll(),
            new FileTransformer()
        );

        $query = $request->getQueryParams();
        $this->manager->parseIncludes(isset($query['include']) ? $query['include'] : []);

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }

    /**
     * /file/{id}/.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $args
     *
     * @return ResponseInterface|static
     */
    public function view(ServerRequestInterface $request, ResponseInterface $response, array $args = [])
    {
        /** @var \TapestryCloud\Database\Entities\File $record */
        if (!$record = $this->entityManager->getRepository(\TapestryCloud\Database\Entities\File::class)->find($args['file_id'])) {
            return $response->withStatus(404);
        }

        $resource = new Item($record, new FileTransformer());

        $query = $request->getQueryParams();
        $this->manager->parseIncludes(isset($query['include']) ? $query['include'] : []);

        $response->getBody()->write(json_encode(
            $this->manager->createData($resource)->toArray()
        ));

        return $response;
    }
}
