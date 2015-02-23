<?php
use Cake\Routing\Router;

Router::plugin('CommentManager', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});