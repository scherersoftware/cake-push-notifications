<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin(
    'CakePushNotifications',
    ['path' => '/cake-push-notifications'],
    function (RouteBuilder $routes) {
        $routes->fallbacks('DashedRoute');
    }
);
