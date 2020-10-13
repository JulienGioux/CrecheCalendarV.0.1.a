<?php
require '../config/constRegex.php';
use CrecheCalendar\Auth;
$error = FALSE;
$auth = new Auth($router);



if ($params['logout'] === '1') {
        $messageError = 'Vous êtes déconnecté';
}

if (!empty($_POST)) {
    if (isset($_POST['isEmployee']) && $_POST['isEmployee'] === 'on') {
        $isEmployee = true;
    } else {
        $isEmployee = false;
    }
    $user = $auth->login($_POST['userEmail'], $_POST['password'], $isEmployee);
    if($user) {
        header('Location: ' . $router->generate('home'));
        exit();
    }
    $error = TRUE;
}

if ($error) {
    $messageError = 'Identifiant ou mot de passe incorrect';
}
