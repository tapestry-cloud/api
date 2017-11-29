<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\Taxonomy;

class TaxonomyTransformer extends TransformerAbstract
{
    public function transform(Taxonomy $model)
    {
        return [
            'id'    => $model->getId(),
            'name'  => $model->getName(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/taxonomy/'.$model->getId()),
                ],
                [
                    'rel' => 'siblings',
                    'uri' => apiUri('/content-type/'.$model->getContentType()->getId().'/taxonomy'),
                ],
                [
                    'rel' => 'content-type',
                    'uri' => apiUri('/content-type/'.$model->getContentType()->getId()),
                ],
                [
                    'rel' => 'classification',
                    'uri' => apiUri('/taxonomy/'.$model->getId().'/classifications'),
                ],
            ],
            'meta' => [
                'classification' => $model->getClassifications()->count(),
            ],
        ];
    }
}
