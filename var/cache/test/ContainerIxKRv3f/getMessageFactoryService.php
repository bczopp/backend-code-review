<?php

namespace ContainerIxKRv3f;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getMessageFactoryService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'App\Factory\MessageFactory' shared autowired service.
     *
     * @return \App\Factory\MessageFactory
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Factory/MessageFactory.php';

        return $container->privates['App\\Factory\\MessageFactory'] = new \App\Factory\MessageFactory();
    }
}
