<?php

$meta = [
    'title' => 'Giriş Yap'
];

if (post('submit')) {

    $username = post('username');
    $password = post('password');

    if (!$username) {
        $error = 'Lütfen kullanıcı adınızı yazın.';
    } elseif (!$password) {
        $error = 'Lütfen şifrenizi girin.';
    }

}

require view('login');