<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\Classification;
use TapestryCloud\Database\Entities\File;
use TapestryCloud\Database\Entities\Taxonomy;

class ClassificationTransformer extends TransformerAbstract
{
    /**
     * @var null|Taxonomy
     */
    private $taxonomy;

    /**
     * ClassificationTransformer constructor.
     *
     * @param Taxonomy|null $taxonomy
     */
    public function __construct(Taxonomy $taxonomy = null)
    {
        $this->taxonomy = $taxonomy;
    }

    public function transform(Classification $model)
    {
        if (is_null($this->taxonomy)) {
            $filesUri = '/classification/'.$model->getId().'/files';
            $fileCount = $model->getFiles()->count();
        } else {
            $filesUri = '/taxonomy/'.$this->taxonomy->getId().'/classification/'.$model->getId().'/files';
            // @todo do the below with an EntityRepository and proxy method see: https://stackoverflow.com/questions/23564897/filtering-on-many-to-many-association-with-doctrine2
            $fileCount = $model->getFiles()->filter(function (File $file) {
                return $file->getContentType() === $this->taxonomy->getContentType();
            })->count();
        }

        return [
            'id'    => $model->getId(),
            'name'  => $model->getName(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/classification/'.$model->getId()),
                ],
                [
                    'rel' => 'siblings',
                    'uri' => apiUri('/classifications'),
                ],
                [
                    'rel' => 'files',
                    'uri' => apiUri($filesUri),
                ],
                [
                    'rel' => 'taxonomy',
                    'uri' => apiUri('/classification/'.$model->getId().'/taxonomy'),
                ],
            ],
            'meta' => [
                'files' => $fileCount,
            ],
        ];
    }
}
