<?php

use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
require '../controllers/controller_CreateEmployee.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
?>

    <main class="m-3">
        <div class="px-4">
            <h2>Ajouter un Employé</h2>
            <form action="" method="post" id="formCreateEmployee">
                <div class="grix xs1 sm2">
                    <div class="form-field col-sm2">
                        <label for="selectedCreche">Crèche: </label>
                        <input class="form-control rounded-1" type="text" disabled
                               value="<?= $crecheName ?? 'Veuillez créer et séléctionner une crèche' ?>">
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeeSectionDefault">Assigner une section par défault: </label>
                        <select class="form-control rounded-1" name="formCreateEmployeeSectionDefault" required>
                            <option value="null">Aucune</option>
                            <?php
                            foreach ($arrayCrecheSection as $key => $value) {
                                # créé les liens vers la ou les crèches
                                ?>
                                <option value="<?= $value['section_id'] ?>" <?= (isset($selectedCrecheSectionId) && $selectedCrecheSectionId === intval($value['section_id'])) ? 'selected' : '' ?>>
                                    <?= $value['section_Name'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeeRoles">Type de compte: </label>
                        <select class="form-control rounded-1" id="formCreateEmployeeRoles"
                                name="formCreateEmployeeRoles" placeholder="Entrer le type de compte" required>
                            <?php
                            foreach ($userRoleArray as $key => $value) {
                                if ($value['role_name'] == 'Admin') {
                                    continue;
                                }
                                ?>
                                <option value="<?= $value['role_id']; ?>" <?= (isset($_POST['formCreateEmployeeRoles']) && $value['role_id'] == $_POST['formCreateEmployeeRoles']) ? 'selected' : (($value['role_id']) ? 'selected' : ''); ?>><?= $value['role_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeeGender">Genre: </label>
                        <select class="form-control rounded-1" id="formCreateEmployeeGender"
                                name="formCreateEmployeeGender" placeholder="Entrer le genre" required>
                            <?php
                            foreach ($userGendersArray as $key => $value) {
                                ?>
                                <option value="<?= $value['gender_id']; ?>" <?= (isset($_POST['formCreateEmployeeGender']) && $value['gender_id'] == $_POST['formCreateEmployeeGender']) ? 'selected' : ''; ?>><?= $value['gender']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeeUserFunction">Fonction/Poste: </label>
                        <select class="form-control rounded-1" id="formCreateEmployeeUserFunction"
                                name="formCreateEmployeeUserFunction" placeholder="Entrer la fonction" required>
                            <?php
                            foreach ($userFunctionsArray as $key => $value) {
                                ?>
                                <option value="<?= $value['function_id']; ?>" <?= (isset($_POST['formCreateEmployeeUserFunction']) && $value['function_id'] == $_POST['formCreateEmployeeUserFunction']) ? 'selected' : (($value['function_id']) ? 'selected' : ''); ?>><?= $value['function_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeefName">Prénom: </label>
                        <input class="form-control rounded-1" type="text" id="formCreateEmployeefName"
                               name="formCreateEmployeefName"
                               value="<?= ($_POST['formCreateEmployeefName']) ?? null; ?>"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer votre prénom" required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['fName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['fName'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeelName">Nom: </label>
                        <input class="form-control rounded-1" type="text" id="formCreateEmployeelName"
                               name="formCreateEmployeelName"
                               value="<?= ($_POST['formCreateEmployeelName']) ?? null; ?>"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer votre nom" required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['lName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['lName'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeeUserPhone">Phone: </label>
                        <input class="form-control rounded-1" type="tel" id="formCreateEmployeeUserPhone"
                               name="formCreateEmployeeUserPhone"
                               value="<?= ($_POST['formCreateEmployeeUserPhone']) ?? null; ?>"
                               placeholder="Votre numéro de tel" pattern="<?= substr(PHONE_FR_REGEX, 1, -1); ?>"
                               required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['userPhone'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['userPhone'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field col">
                        <label for="formCreateEmployeeUserEmail">Email: </label>
                        <input class="form-control rounded-1" type="email" id="formCreateEmployeeUserEmail"
                               name="formCreateEmployeeUserEmail"
                               value="<?= ($_POST['formCreateEmployeeUserEmail']) ?? null; ?>"
                               placeholder="votre.mail@mail.com" pattern="<?= substr(MAIL_REGEX, 1, -1); ?>" required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['userEmail'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['userEmail'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeePwd1">Mot de passe: </label>
                        <input class="form-control rounded-1" type="password" id="formCreateEmployeePwd1"
                               name="formCreateEmployeePwd1" pattern="<?= substr(PWD_REGEX, 1, -1); ?>" required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['Pwd1'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['Pwd1'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="formCreateEmployeePwd2">Vérifier mot de passe: </label>
                        <input class="form-control rounded-1" type="password" id="formCreateEmployeePwd2"
                               name="formCreateEmployeePwd2" pattern="<?= substr(PWD_REGEX, 1, -1); ?>" required>
                        <span class="form-helper <?= (isset($errorFormCreateEmployee['Pwd2'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorFormCreateEmployee['Pwd2'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field col-sm2">
                        <input data-neu-click="neu-pressed" class="btn rounded-2 neu-concave mx-auto" type="submit"
                               id="formCreateEmployeeSubmit" name="formCreateEmployeeSubmit" value="S'inscrire"
                               <?= (isset($crecheName)) ?:'disabled'?>>
                    </div>
                </div>
            </form>
        </div>
    </main>
<?php
require '../elements/jsToast.php';
ob_start();
?>
    <script src="/assets/js/validateFormInputs.js"></script>
<?php
$jsValidateFormInput = ob_get_clean();
?>