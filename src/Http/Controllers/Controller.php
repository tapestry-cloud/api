<?php

namespace TapestryCloud\Api\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use TapestryCloud\Api\App;

class Controller
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var App
     */
    protected $app;

    /**
     * ContentType constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param App                    $app
     */
    public function __construct(EntityManagerInterface $entityManager, App $app)
    {
        $this->entityManager = $entityManager;
        $this->manager = new Manager();
        $this->app = $app;
    }
}
