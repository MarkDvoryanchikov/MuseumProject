<?php

require_once('config.php');

$auth_error = '';
if (isset($_POST['auth'])) {
    $password = $_POST['password'];
    if (!$USER->authorise($password)) {
        $auth_error = "Неверный пароль";
    }
}

if (isset($_POST['logout'])) {
     $USER->logout();
}

$model = get_base_model();
if ($USER->is_admin()) {
    echo $Twig->render('museum.html', $model);
} else {
    $model['error'] = $auth_error;
    echo $Twig->render('loginform.html', $model);
}
