<?php

namespace ShieldWall\SimpleAuthenticator\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SimpleAuthenticatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $routes = $config['route'];

        $container->setParameter('shield_w4ll.simple_authenticator.route.redirect_success', $routes['redirect_success']);
        $container->setParameter('shield_w4ll.simple_authenticator.route.redirect_failure', $routes['redirect_failure']);
    }
}
