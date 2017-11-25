<?php

namespace TapestryCloud\Api\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use TapestryCloud\Database\Entities\File;
use TapestryCloud\Database\Entities\Taxonomy;

class FileTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'frontmatter'
    ];

    public function transform(File $model) {
        return [
            'id' => $model->getId(),
            'uid' => $model->getUid(),
            'filename' => $model->getFilename(),
            'ext' => $model->getExt(),
            'path' => $model->getPath(),
            'lastModified' => $model->getLastModified(),
            'toCopy' => $model->isToCopy(),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/file/' . $model->getId())
                ],
                [
                    'rel' => 'siblings',
                    'uri' => apiUri('/content-type/' . $model->getContentType()->getId() . '/files')
                ],
                [
                    'rel' => 'content-type',
                    'uri' => apiUri('/content-type/' . $model->getContentType()->getId())
                ],
            ],
            'meta' => [
                'frontmatter' => $model->getFrontMatter()->count()
            ]
        ];
    }

    /**
     * Include FrontMatter
     *
     * @param File $file
     * @return Collection
     */
    public function includeFrontMatter(File $file)
    {
        return $this->collection($file->getFrontMatter(), new FrontMatterTransformer);
    }
}