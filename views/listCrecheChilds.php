<?php

use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
require '../controllers/controller_ListCrecheChilds.php';
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
                <p>Grâce au service <strong>CrecheCalendar</strong> vous pouvez voir et modifier la liste des enfants
                    inscrit dans la crèche et la section sélectionné.
            </div>
        </div>
    </section>
    <section class="card rounded-1 mx-auto neu-concave neu-snow neu-bg-lighten">
        <div class="card-header neu-blue">
            <i class="fas fa-school mx-2"></i>Liste des enfants de la crèche
        </div>
        <div class="divider"></div>
        <div class="card-content">
            <div class="form-helper txt-center rounded-1
            <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'txt-error neu-convex' : 'txt-success'); ?> txt-dark-2 py-2">
                <?= $messageError ?? $successMsg ?? ''; ?>
            </div>
            <?php
            if (isset($arrayChilds) && !empty($arrayChilds)) {

                foreach ($arrayChilds as $key => $value) {
                    ?>
                    <div class="card rounded-3 neu-flat">
                        <div class="card-content">
                            <form class="grix xs1 sm2" name="updateChildForm" method="POST" action="">
                                <fieldset>
                                    <legend class="btn shadow-1 rounded-1 txt-white lh-1 m-0 p-2 neu-blue">Enfant</legend>
                                    <input type="hidden" value="<?= $value['child_id'] ?>" name="InputChildId">
                                    <input type="hidden" value="<?= $value['parent_id'] ?>" name="InputRespLegId">
                                    <div class="form-field">
                                        <label for="InputChild_fName">Prénom :</label>
                                        <input type="text" value="<?= $value['child_fName'] ?>" name="InputChild_fName">
                                    </div>
                                    <div class="form-field">
                                        <label for="InputChild_lName">Nom :</label>
                                        <input type="text" value="<?= $value['child_lName'] ?>" name="InputChild_lName">
                                    </div>
                                    <div class="form-field">
                                        <label for="InputDateOfBirth">Date de naissance :</label>
                                        <input type="date" value="<?= $value['dateOfBirth'] ?>" name="InputDateOfBirth">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend class="btn rounded-1 shadow-1 txt-white lh-1 m-0 p-2 neu-blue">Responsable légal</legend>
                                    <div class="form-field">
                                        <label for="InputRespLeg_fName">Prénom du responsable légal :</label>
                                        <input type="text" value="<?= $value['respLeg_fName'] ?>"
                                               name="InputRespLeg_fName">
                                    </div>
                                    <div class="form-field">
                                        <label for="InputRespLeg_lName">Nom du responsable légal :</label>
                                        <input type="text" value="<?= $value['respLeg_lName'] ?>"
                                               name="InputRespLeg_lName">
                                    </div>
                                </fieldset>
                                <div class="form-field d-inline txt-center col-xs1 col-sm2">

                                        <input data-neu-click="neu-pressed" class="btn d-inline rounded-2 p-2 neu-convex mx-2" type="submit" value="modifier" name="updateChildBtn">

                                        <input data-neu-click="neu-pressed" class="btn d-inline rounded-2 p-2 neu-convex mx-2" type="submit" value="Supprimer" name="deleteChildBtn">

                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                }

            } else if (empty($arrayChilds)) {
                ?>
                <p>Il n'y a pas encore d'enfant associé à cette crèche/section.</p>
                <?php
            } else {
                ?>
                <p>Veuillez sélectionner une crèche et éventuellement une section pour afficher la liste d'enfant.</p>
                <?php
            }
            ?>
        </div>
    </section>
</main>
<?php
require '../elements/jsToast.php';
ob_start();
?>
    <script src="/assets/js/validateFormInputs.js"></script>
    </script>
<?php
$jsValidateFormInput = ob_get_clean();
?>