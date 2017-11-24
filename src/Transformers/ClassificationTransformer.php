<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\Classification;

class ClassificationTransformer extends TransformerAbstract
{
    public function transform(Classification $model) {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/taxonomy/{id}/classification/{id}'),
                ],
                [
                    'rel' => 'siblings',
                    'uri' => apiUri('/taxonomy/{id}/classifications'),
                ],
                [
                    'rel' => 'files',
                    'uri' => apiUri('/taxonomy/{id}/classification/{id}/files'),
                ]
            ],
            'meta' => [
                'files' => 0,
            ]
        ];
    }

}