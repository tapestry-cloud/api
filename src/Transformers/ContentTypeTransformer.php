<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\ContentType;

class ContentTypeTransformer extends TransformerAbstract
{
    public function transform(ContentType $model)
    {
        return [
            'id'        => $model->getId(),
            'name'      => $model->getName(),
            'path'      => $model->getPath(),
            'permalink' => $model->getPermalink(),
            'template'  => $model->getTemplate(),
            'endabled'  => $model->getEnabled(),
            'links'     => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/content-type/'.$model->getId()),
                ],
                // [
                //     'rel' => 'environment',
                //     'uri' => '/environment/' . $model->getEnvironment()->getId(),
                // ],
                [
                    'rel' => 'taxonomy',
                    'uri' => apiUri('/content-type/'.$model->getId().'/taxonomy'),
                ],
                [
                    'rel' => 'files',
                    'uri' => apiUri('/content-type/'.$model->getId().'/files'),
                ],
            ],
            'meta' => [
                'taxonomy' => $model->getTaxonomy()->count(),
                'files'    => $model->getFiles()->count(),
            ],
        ];
    }
}
