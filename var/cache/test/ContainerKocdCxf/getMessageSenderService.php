<?php

namespace ContainerKocdCxf;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getMessageSenderService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'App\EventListener\MessageSender' shared autowired service.
     *
     * @return \App\EventListener\MessageSender
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/EventListener/MessageSender.php';
        include_once \dirname(__DIR__, 4).'/src/Factory/ChannelSpecificMessageFactory.php';

        $a = ($container->services['messenger.bus.default.test-bus'] ?? $container->load('getMessenger_Bus_Default_TestbusService'));

        if (isset($container->privates['App\\EventListener\\MessageSender'])) {
            return $container->privates['App\\EventListener\\MessageSender'];
        }

        return $container->privates['App\\EventListener\\MessageSender'] = new \App\EventListener\MessageSender(($container->privates['App\\Repository\\MessageRepository'] ?? $container->load('getMessageRepositoryService')), ($container->privates['App\\Factory\\ChannelSpecificMessageFactory'] ??= new \App\Factory\ChannelSpecificMessageFactory()), $a, ($container->services['doctrine.orm.default_entity_manager'] ?? self::getDoctrine_Orm_DefaultEntityManagerService($container)));
    }
}
