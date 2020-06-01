<?php

require __DIR__ . '/app/init.php';

$route = array_filter(explode('/', $_SERVER['REQUEST_URI']));
if (SUBFOLDER === true){
    array_shift($route);
}

if (!route(0)){
    $route[0] = 'index';
}

if (!file_exists(controller(route(0)))){
    $route[0] = '404';
}

if (setting('maintenance_mode') == 1 && route(0) != 'admin'){
    $route[0] = 'maintenance-mode';
}

require controller(route(0));