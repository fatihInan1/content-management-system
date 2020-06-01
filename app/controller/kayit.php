<?php

$meta = [
    'title' => 'Kayıt Ol'
];

if (post('submit')) {

    $username = post('username');
    $email = post('email');
    $password = post('password');
    $password_again = post('password_again');


    if (!$username) {
        $error = 'Lütfen kullanıcı adınızı yazın.';
    } elseif (!$email) {
        $error = 'Lütfen e-posta adresinizi yazın.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Lütfen geçerli bir e-posta adresi yazın.';
    } elseif (!$password || !$password_again) {
        $error = 'Lütfen şifrenizi girin.';
    } elseif ($password != $password_again) {
        $error = 'Girdiğiniz şifreler birbiriyle uyuşmuyor.';
    } else {

        // üye var mı kontrol et
        $query = $db->prepare('SELECT * FROM users WHERE user_name = :username OR user_email = :email');
        /* if (!$query) {
             echo "\nPDO::errorInfo():\n";
             print_r($db->errorInfo());
         }*/


        $query->execute([
            ':username' => $username,
            ':email' => $email
        ]);
        $row = $query->fetch(PDO::FETCH_ASSOC);


        if ($row) {
            $error = 'Bu kullanıcı adı ya da e-posta zaten kullanılıyor. Lütfen başka bir tane deneyin.';
        } else {

            // üyeyi ekle
            $query = $db->prepare('INSERT INTO users SET user_name = :username, user_url = :url, user_email = :email, user_password = :password');
            //$query = $db->prepare('INSERT INTO users (user_name, user_url, user_email, user_password) VALUES(:user_password, :url, :email, :password)');
            $result = $query->execute([
                ':username' => $username,
                ':url' => permalink($username),
                ':email' => $email,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            if ($result) {
                $success = 'Üyeliğiniz başarıyla oluşturuldu, yönlendiriliyorsunuz.';
                header('Refresh:2;url=' . site_url());
            } elseif ($result === false) {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
                $error = 'Bir sorun oluştu, lütfen daha sonra tekrar deneyin.';
            }

        }

    }

}

require view('register');