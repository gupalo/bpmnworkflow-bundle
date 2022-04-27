<?php

namespace Gupalo\BpmnWorkflowBundle\DependencyInjection;

use Exception;
use Gupalo\BpmmWorkflowBundle\Tests\Example\Extension\PriceFunction;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BpmnWorkflowExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $env = $container->getParameter('kernel.environment');
        
        if ($env === 'test') {
            $loader->load('services_test.yaml');    
        }
    }
}
