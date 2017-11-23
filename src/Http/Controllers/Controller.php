<?php

namespace TapestryCloud\Api\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;

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
     * ContentType constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->manager = new Manager();
    }
}