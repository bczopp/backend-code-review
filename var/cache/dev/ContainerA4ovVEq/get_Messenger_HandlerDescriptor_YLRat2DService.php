<?php

namespace ContainerA4ovVEq;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Messenger_HandlerDescriptor_YLRat2DService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.messenger.handler_descriptor.YLRat2D' shared service.
     *
     * @return \Symfony\Component\Messenger\Handler\HandlerDescriptor
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/HandlerDescriptor.php';
        include_once \dirname(__DIR__, 4).'/src/EventListener/MessageSender.php';
        include_once \dirname(__DIR__, 4).'/src/Factory/ChannelSpecificMessageFactory.php';

        $a = ($container->services['messenger.default_bus'] ?? self::getMessenger_DefaultBusService($container));

        if (isset($container->privates['.messenger.handler_descriptor.YLRat2D'])) {
            return $container->privates['.messenger.handler_descriptor.YLRat2D'];
        }
        $b = ($container->services['doctrine.orm.default_entity_manager'] ?? self::getDoctrine_Orm_DefaultEntityManagerService($container));

        if (isset($container->privates['.messenger.handler_descriptor.YLRat2D'])) {
            return $container->privates['.messenger.handler_descriptor.YLRat2D'];
        }

        return $container->privates['.messenger.handler_descriptor.YLRat2D'] = new \Symfony\Component\Messenger\Handler\HandlerDescriptor(new \App\EventListener\MessageSender(($container->privates['App\\Repository\\MessageRepository'] ?? $container->load('getMessageRepositoryService')), new \App\Factory\ChannelSpecificMessageFactory(), $a, $b), []);
    }
}