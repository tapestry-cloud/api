<?php

namespace TapestryCloud\Api\Services;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tapestry\Console\DefaultInputDefinition;

class Configuration extends AbstractServiceProvider
{

    /** @var array */
    protected $provides = [
        \Tapestry\Entities\Configuration::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->share(\Tapestry\Entities\Configuration::class, function () {
            $configuration = new \Tapestry\Entities\Configuration(include __DIR__ . '/../../config.php');
            return $configuration;
        });
    }
}