<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\ContentType;

class ContentTypeTransformer extends TransformerAbstract
{
    public function transform(ContentType $model) {
        return [
            //'id' => $model->getId(),
            'name' => $model->getName(),
            'path' => $model->getPath(),
            'permalink' => $model->getPermalink(),
            'template' => $model->getTemplate(),
            'endabled' => $model->getEnabled(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/content-type/' . $model->getName()
                ],
                [
                    'rel' => 'environment',
                    'uri' => '/environment/' . $model->getEnvironment()->getId()
                ],
                [
                    'rel' => 'taxonomy',
                    'uri' => '/content-type/' . $model->getName() . '/taxonomy',
                ],
                [
                    'rel' => 'files',
                    'uri' => '/content-type/' . $model->getName() . '/files',
                ]
            ],
            'meta' => [
                'taxonomy' => $model->getTaxonomy()->count(),
                'files' => 0 //@todo right now the database plugin doesn't implement files on the content type, you have to dig down through taxonomy -> classification -> files to get them
            ]
        ];
    }

}