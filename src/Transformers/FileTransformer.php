<?php

namespace TapestryCloud\Api\Transformers;

use Carbon\Carbon;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Symfony\Component\Finder\SplFileInfo;
use Tapestry\Entities\File as TapestryFile;
use Tapestry\Entities\Project;
use TapestryCloud\Database\Entities\File;

class FileTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'frontmatter',
    ];

    /**
     * @var Project
     */
    private $project;

    /**
     * FileTransformer constructor.
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    private function constructTapestryFile(File $model)
    {
        return new TapestryFile(
            new SplFileInfo(
                $this->project->sourceDirectory . DIRECTORY_SEPARATOR . $model->getPath() . DIRECTORY_SEPARATOR . $model->getFilename() . '.' . $model->getExt(),
                '',''
            ), []
        );
    }

    public function transform(File $model)
    {
        $file = $this->constructTapestryFile($model);

        /** @var \DateTime $date */
        $date = $file->getData('date');

        return [
            'id'           => $model->getId(),
            'uid'          => $model->getUid(),
            'filename'     => $model->getFilename(),
            'ext'          => $model->getExt(),
            'path'         => $model->getPath(),
            'lastModified' => $model->getLastModified(),
            'date'         => $date->getTimestamp(),
            'slug'         => $file->getData('slug'),
            'draft'        => $file->getData('draft', false),
            'pretty_permalink' => $file->getData('pretty_permalink', true),
            // 'permalink'    => [
            //     'template' => $file->getPermalink()->getTemplate(),
            //     'compiled' => $file->getCompiledPermalink()
            // ],
            'toCopy'       => $model->isToCopy(),
            'links'        => [
                [
                    'rel' => 'self',
                    'uri' => apiUri('/file/'.$model->getId()),
                ],
                [
                    'rel' => 'siblings',
                    'uri' => apiUri('/content-type/'.$model->getContentType()->getId().'/files'),
                ],
                [
                    'rel' => 'content-type',
                    'uri' => apiUri('/content-type/'.$model->getContentType()->getId()),
                ],
            ],
            'meta' => [
                'frontmatter' => $model->getFrontMatter()->count(),
            ],
        ];
    }

    /**
     * Include FrontMatter.
     *
     * @param File $file
     *
     * @return Collection
     */
    public function includeFrontMatter(File $file)
    {
        return $this->collection($file->getFrontMatter(), new FrontMatterTransformer());
    }
}
