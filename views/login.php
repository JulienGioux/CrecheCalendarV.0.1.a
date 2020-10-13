<?php

ob_start();
require '../controllers/controller_Nav.php';
require '../controllers/controller_Login.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
?>
<main class="m-5">
    <div class="card rounded-3 mx-auto neu-concave neu-snow neu-bg-lighten">
        <div class="card-header neu-snow neu-bg-darken">Se connecter</div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-helper txt-center rounded-1 p-2 <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'error' : 'txt-success'); ?> txt-dark-2 pb-2">
                <?= $messageError ?? $successMsg ?? 'Veuillez entrer vos identifiants'; ?>
            </div>
            <form action="" method="post">
                <div class="grix xs1 md3 xl4">
                    <div class="form-field col-md3">
                        <label for="userEmail">Email: </label>
                        <input class="form-control rounded-1" type="email" id="userEmail" name="userEmail"
                               placeholder="votre.mail@mail.com" pattern="<?= substr(MAIL_REGEX, 1, -1); ?>" required>
                    </div>
                    <div class="form-field col-md3">
                        <label for="password">Mot de passe: </label>
                        <input class="form-control rounded-1" type="password" id="password" name="password"
                               placeholder="Entrer votre mot de passe" pattern="<?= substr(PWD_REGEX, 1, -1); ?>"
                               required>
                        <span class="form-helper txt-center <?= (isset($errorConnection['login'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $errorConnection['login'] ?? '' ?></span>
                    </div>
                    <div class="form-field col-md3">
                        <label class="form-switch mx-auto">
                            Membre du personnel
                            <input type="checkbox" id="isEmployee" name="isEmployee">
                            <span class="slider small"></span>
                        </label>
                    </div>
                    <div class="form-field col-md3">
                        <input class="btn rounded-1 neu-snow neu-convex mx-auto" type="submit" id="formConnectUser"
                               name="formConnectUser" value="Se connecter">
                    </div>

                </div>
            </form>
        </div>

    </div>
</main>
<?php
require '../elements/jsToast.php';
?>



  
