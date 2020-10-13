<?php

use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
require '../controllers/controller_CreateCrecheSection.php';
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
                <p>Assurez vous de bien séléctionner la crèche et la section que vous souhaitez administrer
                    dans le menu principal.</p>
            </div>
        </div>
    </section>
    <section class="card rounded-1 mx-auto neu-concave neu-snow neu-bg-lighten">
        <div class="card-header neu-blue">
            <i class="fas fa-puzzle-piece mx-2"></i>Sections
        </div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-helper txt-center rounded-1
            <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'txt-error neu-convex' : 'txt-success'); ?> txt-dark-2 py-2">
                <?= $messageError ?? $successMsg ?? ''; ?>
            </div>
            <form action="" method="post">
                <div class="form-field">
                    <label for="selectedCreche">Crèche: </label>
                    <input class="form-control rounded-1" type="text" disabled
                           value="<?= ($crecheName) ?? 'Veuillez créer et séléctionner une crèche' ?>">
                </div>
                <div class="form-field col-md3">
                    <label for="crecheSection">Nom de la section</label>
                    <input class="form-control rounded-1" type="text" id="crecheSection" name="crecheSection"
                           placeholder="Entrer le nom de la section" pattern="<?= substr(NAME_REGEX, 1, -1); ?>"
                           required>
                </div>
                <div class="grix xs1 sm3">
                    <div class="form-field col-sm3">
                        <input data-neu-click="neu-pressed" class="btn rounded-2 neu-concave mx-auto" type="submit"
                               id="formCreateSection"
                               name="formCreateSection" value="Ajouter">
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