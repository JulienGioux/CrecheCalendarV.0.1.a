<?php
use CrecheCalendar\Employee;
use CrecheCalendar\UserGender;
use CrecheCalendar\UserFunction;
use CrecheCalendar\UserRole;

require '../config/constRegex.php';

$errorFormCreateEmployee = [];
$registerEmployeeSuccess = false;

$userFunctions = new UserFunction();
$userFunctionsArray = $userFunctions->getFunctions();

$userGender = new UserGender();
$userGendersArray = $userGender->getGenders();

$userRole = new UserRole();
$userRoleArray = $userRole->getAllRoles();


$crecheEmployee = new Employee();

/**
 * Vérifie qu'au moins une crèche existe et est séléctionné
 *
 */
if (isset($selectedCrecheId)) {
    $crecheName = $creche->getCrecheNameById($selectedCrecheId);
} else {
    $crecheName = null;
}


if (isset($_POST['formCreateEmployeefName'])) {

    if (!preg_match(NAME_REGEX, $_POST['formCreateEmployeefName'])) {
        $errorFormCreateEmployee['fName'] = 'Mauvais format';
    };
    if (empty($_POST['formCreateEmployeefName'])) {
        $errorFormCreateEmployee['fName'] = 'Veuillez renseigner le champ';
    }
}


if (isset($_POST['formCreateEmployeelName'])) {

    if (!preg_match(NAME_REGEX, $_POST['formCreateEmployeelName'])) {
        $errorFormCreateEmployee['lName'] = 'Mauvais format';
    };
    if (empty($_POST['formCreateEmployeelName'])) {
        $errorFormCreateEmployee['lName'] = 'Veuillez renseigner le champ';
    }
}


if (isset($_POST['formCreateEmployeeUserEmail'])) {

    if (!filter_var($_POST['formCreateEmployeeUserEmail'], FILTER_VALIDATE_EMAIL)) {
        $errorFormCreateEmployee['userEmail'] = 'Mauvais Format';
    };
    $postRoleName = $userRole->getRoleName($_POST['formCreateEmployeeRoles'])['role_name'];
    if ($crecheEmployee->VerifyMailExist($_POST['formCreateEmployeeUserEmail'], $postRoleName)) {
        $errorFormCreateEmployee['userEmail'] = 'Le mail " ' . htmlspecialchars($_POST['formCreateEmployeeUserEmail']) . ' " existe déja';
    };
    if (empty($_POST['formCreateEmployeeUserEmail'])) {
        $errorFormCreateEmployee['userEmail'] = 'Veuillez Renseigner le champ';
    };
};


if (isset($_POST['formCreateEmployeeUserPhone'])) {

    if (!preg_match(PHONE_FR_REGEX, $_POST['formCreateEmployeeUserPhone'])) {
        $errorFormCreateEmployee['userPhone'] = 'Mauvais Format';
    };
    if (empty($_POST['formCreateEmployeeUserPhone'])) {
        $errorFormCreateEmployee['userPhone'] = 'Veuillez Renseigner le champ';
    };
};

if (isset($_POST['formCreateEmployeePwd1']) && isset($_POST['formCreateEmployeePwd2'])) {

    if (!preg_match(PWD_REGEX, $_POST['formCreateEmployeePwd1'])) {
        $errorFormCreateEmployee['Pwd1'] = 'Mauvais Format';
    };
    if (empty($_POST['formCreateEmployeePwd1'])) {
        $errorFormCreateEmployee['Pwd1'] = 'Veuillez Renseigner le champ';
    };
    if (empty($_POST['formCreateEmployeePwd2'])) {
        $errorFormCreateEmployee['Pwd2'] = 'Veuillez Renseigner le champ';
    };
    if ($_POST['formCreateEmployeePwd2'] != $_POST['formCreateEmployeePwd1']) {
        $errorFormCreateEmployee['Pwd1'] = 'Les mots de passe ne sont pas identiques';
        $errorFormCreateEmployee['Pwd2'] = 'Les mots de passe ne sont pas identiques';
    };
};


if (isset($_POST['formCreateEmployeeSubmit']) && count($errorFormCreateEmployee) === 0) {


    $fName = htmlspecialchars($_POST['formCreateEmployeefName']);
    $lName = htmlspecialchars($_POST['formCreateEmployeelName']);
    $gender = htmlspecialchars($_POST['formCreateEmployeeGender']);
    $userEmail = htmlspecialchars($_POST['formCreateEmployeeUserEmail']);
    $userPhone = htmlspecialchars($_POST['formCreateEmployeeUserPhone']);
    $password = password_hash($_POST['formCreateEmployeePwd1'], PASSWORD_DEFAULT);
    $function = htmlspecialchars($_POST['formCreateEmployeeUserFunction']);
    $roleId = htmlspecialchars($_POST['formCreateEmployeeRoles']);
    $crecheId = $selectedCrecheId;
    $sectionId = htmlspecialchars($_POST['formCreateEmployeeSectionDefault']);

    $crecheEmployee->createEmployee($fName, $lName, $gender, $userEmail, $userPhone, $password, $function, $roleId, ($crecheId == 'null') ? $crecheId = null : $crecheId, ($sectionId == 'null') ? $sectionId = null : $sectionId);
    $registerEmployeeSuccess = true;
} else {
    $messageError = 'Erreur : il y a eu un problème lors de votre enregistrement';
};



if (isset($errorFormCreateEmployee)) {
    $listErrors = '';
    foreach ($errorFormCreateEmployee as $key => $value) {
        $listErrors = $listErrors . 'Erreur : ' . $value . '<br>';
    }
}
if ($registerEmployeeSuccess === true) {
    $successMsg = 'L\'utilisateur ' . $fName . ' ' . $lName . ' a bien été enregistré.';
}