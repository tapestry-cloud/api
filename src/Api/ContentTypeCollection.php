<?php

namespace TapestryCloud\Api\Api;

use League\Fractal\Resource\Collection;
use TapestryCloud\Database\Entities\ContentType;
use TapestryCloud\Database\Entities\Taxonomy;

class ContentTypeCollection
{
    public function getIndexResource(array $collection)
    {
        return new Collection($collection, function(ContentType $contentType){
            return [
                'name' => $contentType->getName(),
                'path' => $contentType->getPath(),
                'taxonomy' => [
                    'count' => $contentType->getTaxonomy()->count(),
                    '_path' => '/content-types/'. $contentType->getName() .'/taxonomies'
                ],
                'files' => [
                    'count' => 0,
                    '_path' => '/content-types/'. $contentType->getName() .'/files'
                ]
            ];
        });
    }

    public function getTaxonomiesResource(ContentType $contentType) {

        return new Collection($contentType->getTaxonomy()->toArray(), function (Taxonomy $taxonomy){
            return [
                '_self' => '/taxonomy/'.$taxonomy->getName(),
                'name' => $taxonomy->getName(),
                'classifications' => [
                    'count' => $taxonomy->getClassifications()->count(),
                    '_path' => '/taxonomy/'.$taxonomy->getName().'/classifications',
                ]
            ];
        });

    }
}