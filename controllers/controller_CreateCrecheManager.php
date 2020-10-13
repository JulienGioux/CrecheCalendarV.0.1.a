<?php

use CrecheCalendar\Employee;
use CrecheCalendar\UserFunction;
use CrecheCalendar\UserGender;

require '../config/constRegex.php';

if (isset($_SESSION['auth']['id'])) {
    header('Location: ' . $router->generate('logout'));
    exit();
}
$crecheManager = new Employee();
$userFunctions = new UserFunction();
$userFunctionsArray = $userFunctions->getFunctions();
$userGender = new UserGender();
$userGendersArray = $userGender->getGenders();
$error = [];


if (isset($_POST['fName'])) {

    if (!preg_match(NAME_REGEX, $_POST['fName'])) {
        $error['Prénom'] = 'Mauvais format';
    };
    if (empty($_POST['fName'])) {
        $error['Prénom'] = 'Veuillez renseigner le champ';
    }
}

if (isset($_POST['lName'])) {

    if (!preg_match(NAME_REGEX, $_POST['lName'])) {
        $error['Nom'] = 'Mauvais format';
    };
    if (empty($_POST['lName'])) {
        $error['Nom'] = 'Veuillez renseigner le champ';
    }
}

if (isset($_POST['userEmail'])) {

    if (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
        $error['Email'] = 'Mauvais Format';
    };
    if ($crecheManager->VerifyMailExist($_POST['userEmail'], 'Modérateur')) {
        $error['Email'] = 'Le compte " ' . $_POST['userEmail'] . ' " existe déja';
    };
    if (empty($_POST['userEmail'])) {
        $error['Email'] = 'Veuillez Renseigner le champ';
    };
};

if (isset($_POST['userPhone'])) {

    if (!preg_match(PHONE_FR_REGEX, $_POST['userPhone'])) {
        $error['Tél.'] = 'Mauvais Format';
    };
    if (empty($_POST['userPhone'])) {
        $error['Tél.'] = 'Veuillez Renseigner le champ';
    };
};

if (isset($_POST['pwd1']) && isset($_POST['pwd2'])) {

    if (!preg_match(PWD_REGEX, $_POST['pwd1'])) {
        $error['password'] = 'Mauvais Format';
    };
    if (empty($_POST['pwd1'])) {
        $error['password'] = 'Veuillez Renseigner le champ';
    };
    if (empty($_POST['pwd2'])) {
        $error['password'] = 'Veuillez Renseigner le champ';
    };
    if ($_POST['pwd2'] != $_POST['pwd1']) {
        $error['password'] = 'Les mots de passe ne sont pas identiques';
    };
};

if (isset($error)) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .=  $value . '<br>';
    }
}
if (isset($_POST['formCreateCrecheManager']) && count($error) == 0) {



        $fName = htmlspecialchars($_POST['fName']);
        $lName = htmlspecialchars($_POST['lName']);
        $gender = htmlspecialchars($_POST['gender']);
        $userEmail = htmlspecialchars($_POST['userEmail']);
        $userPhone = htmlspecialchars($_POST['userPhone']);
        $password = password_hash($_POST['pwd1'], PASSWORD_DEFAULT);
        $function = htmlspecialchars($_POST['userFunction']);

        $crecheManager->createCrecheManager($fName, $lName, $gender, $userEmail, $userPhone, $password, $function);
        $_SESSION['RegisterManagerSuccess'] = true;


} else {
    if (isset($_POST['formCreateCrecheManager'])) {
        $messageError .= 'Erreur : il y a eu un problème lors de votre enregistrement';
    }
}
if (isset($_SESSION['RegisterManagerSuccess']) && $_SESSION['RegisterManagerSuccess']) {
    $successMsg = 'Votre compte a été créé, un mail de confirmation vous a été envoyé. 
                <br>Veuillez le consulter et cliquer sur le liens de vérification pour l\'activer.';
    $_SESSION = [];
    unset($_SESSION);
}





