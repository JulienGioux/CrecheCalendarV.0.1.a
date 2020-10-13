<?php
require('../controllers/controller_CreateCrecheManager.php');
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
                <p>L'enregistrement sur la plateforme concerne <b>les gérants de crèche(s)</b>.</p>
                <p>Avec ce compte vous pourrez administrer vos crèches, leurs sections, créer des comptes pour les
                    salariés ainsi que pour les représentants légaux des enfants inscrits.
                    <br>Ce compte permet aussi d'administrer l'ensemble des plannings, par crèche, par section,
                    par employé et par enfant.</p>
            </div>
        </div>
    </section>
    <section class="card rounded-1 mx-auto neu-concave neu-snow neu-bg-lighten">
        <div class="card-header neu-snow neu-bg-darken txt-blue txt-dark-2">
            Créer un compte
        </div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-helper txt-center rounded-1
            <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'txt-error  neu-convex' : 'txt-success'); ?> txt-dark-2 py-2">
                <?= $messageError ?? $successMsg ?? 'Veuillez renseigner tous les champs'; ?>
            </div>
            <form action="" method="post">
                <div class="grix xs1 sm2 pt-2">
                    <div class="form-field">
                        <label for="gender">Genre: </label>
                        <select class="form-control rounded-1" id="gender" name="gender" required>
                            <?php
                            foreach ($userGendersArray as $key => $value) {
                                ?>
                                <option value="<?= $value['gender_id']; ?>"><?= $value['gender']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="userFunction">Fonction/Poste: </label>
                        <select class="form-control rounded-1" id="userFunction" name="userFunction"
                                placeholder="Entrer votre genre" required>
                            <?php
                            foreach ($userFunctionsArray as $key => $value) {
                                ?>
                                <option value="<?= $value['function_id']; ?>"><?= $value['function_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="fName">Prénom: </label>
                        <input class="form-control rounded-1" type="text" id="fName" name="fName"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer votre prénom" required>
                    </div>
                    <div class="form-field">
                        <label for="lName">Nom: </label>
                        <input class="form-control rounded-1" type="text" id="lName" name="lName"
                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>" placeholder="Entrer votre nom" required>
                    </div>
                    <div class="form-field">
                        <label for="userPhone">Phone: </label>
                        <input class="form-control rounded-1" type="tel" id="userPhone" name="userPhone"
                               placeholder="Votre numéro de tel" pattern="<?= substr(PHONE_FR_REGEX, 1, -1); ?>"
                               required>
                    </div>
                    <div class="form-field col">
                        <label for="userEmail">Email: </label>
                        <input class="form-control rounded-1" type="email" id="userEmail" name="userEmail"
                               placeholder="votre.mail@mail.com" pattern="<?= substr(MAIL_REGEX, 1, -1); ?>" required>
                    </div>
                    <div class="form-field">
                        <label for="pwd1">Mot de passe: </label>
                        <input class="form-control rounded-1" type="password" id="pwd1" name="pwd1"
                               placeholder="Choisissez votre mot de passe" pattern="<?= substr(PWD_REGEX, 1, -1); ?>"
                               required>
                    </div>
                    <div class="form-field">
                        <label for="pwd2">Vérifier mot de passe: </label>
                        <input class="form-control rounded-1" type="password" id="pwd2" name="pwd2"
                               placeholder="Vérifier votre mot de passe" pattern="<?= substr(PWD_REGEX, 1, -1); ?>"
                               required>
                    </div>
                    <div class="form-field col-sm2">
                        <input class="btn press rounded-1 blue dark-2 mx-auto" type="submit"
                               id="formCreateCrecheManager"
                               name="formCreateCrecheManager" value="S'inscrire">
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
<?php
require '../elements/jsToast.php';
?>
