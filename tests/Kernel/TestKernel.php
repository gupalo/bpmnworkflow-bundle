<?php

namespace Gupalo\BpmnWorkflowBundle\Tests\Kernel;

use Gupalo\BpmnWorkflowBundle\BpmnWorkflowBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerBundles(): iterable
    {
        $bundles = [];

        if ($this->getEnvironment() === 'test') {
            $bundles[] = new FrameworkBundle();
            $bundles[] = new BpmnWorkflowBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yaml');
    }
}
