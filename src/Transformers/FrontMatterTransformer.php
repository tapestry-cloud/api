<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\File;
use TapestryCloud\Database\Entities\FrontMatter;
use TapestryCloud\Database\Entities\Taxonomy;

class FrontMatterTransformer extends TransformerAbstract
{

    public function transform(FrontMatter $model) {
        return [
            'id' => $model->getId(),
            'name' => $model->getName(),
            'value' => json_decode($model->getValue())
        ];
    }
}