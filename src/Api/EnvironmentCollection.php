<?php

namespace TapestryCloud\Api\Api;

use League\Fractal\Resource\Collection;
use TapestryCloud\Database\Entities\Environment;;

class EnvironmentCollection
{
    public function getIndexResource(array $collection)
    {
        return new Collection($collection, function(Environment $environment){
            return [
                '_self' => '/environment/'. $environment->getId(),
                'id' => $environment->getId(),
                'name' => $environment->getName(),
                'content-types' => [
                    'count' => $environment->getContentTypes()->count(),
                    'path' => '/environment/'. $environment->getId() . '/content-types',
                ],
                'files' => [
                    'count' => $environment->getFiles()->count(),
                    'path' => '/environment/'. $environment->getId() . '/files',
                ]
            ];
        });
    }

}