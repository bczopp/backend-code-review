<?php

namespace ContainerKocdCxf;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getGetMessagesHandlerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'App\CQ\QueryHandler\GetMessagesHandler' shared autowired service.
     *
     * @return \App\CQ\QueryHandler\GetMessagesHandler
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/CQ/QueryHandler/GetMessagesHandler.php';

        return $container->privates['App\\CQ\\QueryHandler\\GetMessagesHandler'] = new \App\CQ\QueryHandler\GetMessagesHandler(($container->privates['App\\Repository\\MessageRepository'] ?? $container->load('getMessageRepositoryService')));
    }
}
