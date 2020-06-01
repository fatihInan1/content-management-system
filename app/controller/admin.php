<?php

if (!route(1)){
    $route[1] = 'index';
}

if (!file_exists(admin_controller(route(1)))){
    $route[1] = 'index';
}

$menus = [
    'index' => [
        'title' => 'Anasayfa',
        'icon' => 'tachometer'
    ],
    'users' => [
        'title' => 'Üyeler',
        'icon' => 'user',
        'submenu' => [
            'add-user' => 'Üye Ekle',
            'users' => 'Üyeleri Liste'
        ]
    ],
    'settings' => [
        'title' => 'Ayarlar',
        'icon' => 'cog'
    ]
];

require admin_controller(route(1));