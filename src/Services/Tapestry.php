<?php

namespace TapestryCloud\Api\Services;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tapestry\Console\DefaultInputDefinition;
use Tapestry\Entities\Project;

class Tapestry extends AbstractServiceProvider
{
    /** @var array */
    protected $provides = [
        \Tapestry\Tapestry::class,
        Project::class,
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
        $this->getContainer()->add(Project::class, function () {
            $tapestry = $this->getContainer()->get(\Tapestry\Tapestry::class);

            return $tapestry->getContainer()->get(Project::class);
        });

        $this->getContainer()->share(\Tapestry\Tapestry::class, function () {
            /** @var \Tapestry\Entities\Configuration $configuration */
            $configuration = $this->getContainer()->get(\Tapestry\Entities\Configuration::class);

            $definitions = new DefaultInputDefinition();
            $tapestry = new \Tapestry\Tapestry(new ArrayInput([
                '--site-dir' => $configuration->get('site-dir'),
                '--env'      => 'testing',
            ], $definitions));

            $tapestry->setOutput(new BufferedOutput());

            return $tapestry;
        });
    }
}
