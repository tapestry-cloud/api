<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\Environment;

class EnvironmentTransformer extends TransformerAbstract
{
    public function transform(Environment $model) {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/environment/' . $model->getId()
                ],
                [
                    'rel' => 'content-types',
                    'uri' => '/environment/' . $model->getId() . '/content-types'
                ],
                [
                    'rel' => 'files',
                    'uri' => '/environment/' . $model->getId() . '/files'
                ],
            ],
            'meta' => [
                'files' => $model->getFiles()->count(),
                'content-types' => $model->getContentTypes()->count()
            ]
        ];
    }
}