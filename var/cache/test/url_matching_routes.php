<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/messages' => [[['_route' => 'app_message_list', '_controller' => 'App\\Controller\\MessageController::list'], null, null, null, false, false, null]],
        '/messages/send' => [[['_route' => 'app_message_send', '_controller' => 'App\\Controller\\MessageController::send'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
    ],
    [ // $dynamicRoutes
    ],
    null, // $checkCondition
];
