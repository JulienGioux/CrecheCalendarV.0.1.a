<?php

use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
require('../controllers/controller_CreateCreche.php');
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
?>


<main class="m-3">
    <section class="card fx-row rounded-1 mx-auto neu-concave neu-snow neu-bg-lighten p-2">
        <div class="txt-blue txt-dark-2 d-flex vtop fx-center px-2">
            <i class="fas fa-info-circle FontSize2rem"></i>
        </div>
        <div class="flex fx-col fx-grow">
            <div class="card-header py-0 txt-blue txt-dark-2">Information :</div>
            <div class="card-content">
                <p>Ajouter une crèche est la première étape pour utiliser le service <strong>CrecheCalendar</strong>.
                    <br>Vous pourrez par la suite séléctionner la crèche que vous souhaitez administrer dans le menu
                    principal.</p>
            </div>
        </div>
    </section>
    <section class="card rounded-1 mx-auto neu-concave neu-snow neu-bg-lighten">
        <div class="card-header neu-blue">
            <i class="fas fa-school mx-2"></i>Ajouter une crèche
        </div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-helper txt-center rounded-1
            <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'txt-error neu-convex' : 'txt-success'); ?> txt-dark-2 py-2">
                <?= $messageError ?? $successMsg ?? ''; ?>
            </div>
            <form action="" method="post">
                <div class="grix xs1 sm2">
                    <div class="form-field">
                        <label for="crecheName">Nom</label>
                        <input type="text" id="crecheName" name="crecheName" class="form-control rounded-1"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer le nom de la crèche"
                               value="<?= $crecheName ?? '' ?>" required/>
                    </div>
                    <div class="form-field">
                        <label for="crecheEmail">Email</label>
                        <input type="email" id="crecheEmail" name="crecheEmail" class="form-control rounded-1"
                               pattern="<?= substr(MAIL_REGEX, 1, -1); ?>" placeholder="contact@example.com"
                               value="<?= $crecheEmail ?? '' ?>" required/>
                    </div>
                    <div class="form-field">
                        <label for="crechePhone">Téléphone</label>
                        <input type="text" id="crechePhone" name="crechePhone" class="form-control rounded-1"
                               pattern="<?= substr(PHONE_FR_REGEX, 1, -1); ?>" placeholder="+33 * ** ** ** **"
                               value="<?= $crechePhone ?? '' ?>" required/>
                    </div>
                    <div class="form-field col-sm2">
                        <label for="crecheAddress1">Addresse</label>
                        <input type="text" id="crecheAddress1" name="crecheAddress1" class="form-control rounded-1"
                               pattern="<?= substr(ADDRESS_REGEX, 1, -1); ?>" placeholder="Entrer l'adresse du site"
                               value="<?= $crecheAddress1 ?? null; ?>" required>
                        <span class="form-helper txt-center <?= (isset($error['Address1'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['Address1'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field col-sm2">
                        <label for="crecheAddress2">Complément d'addresse</label>
                        <input type="text" id="crecheAddress2" name="crecheAddress2" class="form-control rounded-1"
                               pattern="<?= substr(ADDRESS_REGEX, 1, -1); ?>"
                               placeholder="Entrer le complément d'addresse" value="<?= $crecheAddress2 ?? null; ?>">
                        <span class="form-helper txt-center <?= (isset($error['Address2'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['Address2'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="crecheCodePost">Code postale</label>
                        <input type="text" id="crecheCodePost" name="crecheCodePost" class="form-control rounded-1"
                               maxlength="5" pattern="<?= substr(NIC_CODE_POST_REGEX, 1, -1); ?>"
                               placeholder="Entrer le code postal" value="<?= $crecheCodePost ?? null; ?>" required>
                        <span class="form-helper txt-center <?= (isset($error['crecheCodePost'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['crecheCodePost'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="crecheCity">Ville</label>
                        <input type="text" id="crecheCity" name="crecheCity" class="form-control rounded-1"
                               maxlength="50"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer la ville"
                               value="<?= $crecheCity ?? '' ?>" required/>
                        <span class="form-helper txt-center <?= (isset($error['crecheCity'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['crecheCity'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="crecheSiren">S.I.R.E.N</label>
                        <input type="text" id="crecheSiren" name="crecheSiren" class="form-control rounded-1"
                               maxlength="9"
                               pattern="<?= substr(SIREN_REGEX, 1, -1); ?>" placeholder="Entrer le numéro de siren"
                               required/>
                        <span class="form-helper txt-center <?= (isset($error['crecheSiren'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['crecheSiren'] ?? 'requis' ?></span>
                    </div>
                    <div class="form-field">
                        <label for="crecheNic">N.I.C</label>
                        <input type="text" id="crecheNic" name="crecheNic" class="form-control rounded-1" maxlength="5"
                               pattern="<?= substr(NIC_CODE_POST_REGEX, 1, -1); ?>" placeholder="Entrer le numero nic"/>
                        <span class="form-helper txt-center" <?= (isset($error['crecheSiren'])) ? 'txt-red txt-dark-2' : ''; ?>
                        "><?= $error['crecheSiren'] ?? 'requis' ?></span>
                    </div>
                </div>
                <div class="grix xs1 sm3">
                    <div class="form-field col-sm3">
                        <input data-neu-click="neu-pressed" class="btn rounded-2 neu-concave mx-auto" type="submit"
                               id="formCreateCreche"
                               name="formCreateCreche" value="Ajouter">
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
require '../elements/jsToast.php';
ob_start();
?>
<script src="/assets/js/validateFormInputs.js"></script>
<?php
$jsValidateFormInput = ob_get_clean();
?>
