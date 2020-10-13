<?php

use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
require '../controllers/controller_CreateChild.php';
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
                Ajouter un(e) enfant
            </div>
            <div class="divider"></div>
            <div class="card-content">
                <?php if(isset($successMsg) || !empty($messageError)): ?>
                <div class="form-helper txt-center rounded-1
            <?= (isset($successMsg)) ? 'success' : ((isset($messageError)) ? 'txt-error neu-convex' : 'txt-success'); ?> txt-dark-2 py-2">
                    <?= $messageError ?? $successMsg ?? ''; ?>
                </div>
                <?php endif; ?>
                <form action="" method="post" id="formCreateChild">
                    <fieldset class="rounded-1 p-0 neu-bordered neu-snow ">
                        <legend>
                            <h3 class="btn cursor-default neu-snow neu-bg-darken neu-flat rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">
                                Crèche:</h3></legend>
                        <div class="grix xs1 sm2 neu-convex rounded-1 p-2">
                            <div class="form-field">
                                <label for="selectedCreche">Crèche: </label>
                                <input class="form-control rounded-1" type="text" disabled
                                       value="<?= $creche->getCrecheNameById($selectedCrecheId) ?? 'Veuillez créer et séléctionner une crèche' ?>">
                            </div>
                            <div class="form-field">
                                <label for="SectionDefault">Assigner une section par défault: </label>
                                <input class="form-control rounded-1" type="text" disabled

                                       value="<?= $crecheSection->getSectionById($selectedCrecheSectionId)['section_Name'] ?? 'Veuillez créer et séléctionner une section' ?>">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="rounded-1 p-0 neu-bordered neu-snow">
                        <legend>
                            <h3 class="btn cursor-default neu-snow neu-bg-darken neu-flat rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">
                                Responsable légal </h3></legend>
                        <div class="tab full-width neu-convex" id="respLeg-tab" data-ax="tab">
                            <ul class="tab-menu">
                                <li id="addRespLeg"
                                    class="tab-link <?= (($isSubmit != false && $activeTabs === 'addRespLeg')) ? 'active' : '' ?>">
                                    <a href="#tab1">Ajouter</a>
                                </li>
                                <li id="getRespLeg"
                                    class="tab-link <?= (($isSubmit != false && $activeTabs === 'getRespLeg')) ? 'active' : '' ?>">
                                    <a href="#tab2">Sélectionner</a>
                                </li>
                            </ul>
                            <div id="tab1">
                                <div class="grix xs1 sm2 p-2">
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalRespGender">Genre: </label>
                                        <select class="form-control rounded-1" id="formCreateChild_LegalRespGender"
                                                name="formCreateChild_LegalRespGender" required>
                                            <?php
                                            foreach ($userGendersArray as $key => $value) {
                                                ?>
                                                <option value="<?= $value['gender_id']; ?>"
                                                    <?= (isset($respLegalGender) && $value['gender_id'] == $respLegalGender) ? 'selected' : ''; ?>>
                                                    <?= $value['gender']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalRespfName">Prénom: </label>
                                        <input class="form-control rounded-1" type="text"
                                               id="formCreateChild_LegalRespfName" name="formCreateChild_LegalRespfName"
                                               value="<?= $respLegFname ?? null; ?>"
                                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>"
                                               placeholder="Entrer votre prénom" required>
                                        <span class="form-helper <?= (isset($error['LegalRespfName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['LegalRespfName'] ?? 'requis' ?></span>
                                    </div>
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalResplName">Nom: </label>
                                        <input class="form-control rounded-1" type="text"
                                               id="formCreateChild_LegalResplName" name="formCreateChild_LegalResplName"
                                               value="<?= $respLegLname ?? null; ?>"
                                               pattern="<?= substr(NAME_REGEX, 1, -1); ?>"
                                               placeholder="Entrer votre nom" required>
                                        <span class="form-helper <?= (isset($error['LegalResplName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['LegalResplName'] ?? 'requis' ?></span>
                                    </div>
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalRespPhone">Phone: </label>
                                        <input class="form-control rounded-1" type="tel"
                                               id="formCreateChild_LegalRespPhone"
                                               name="formCreateChild_LegalRespPhone"
                                               value="<?= $respLegPhone ?? null; ?>"
                                               placeholder="Votre numéro de tel"
                                               pattern="<?= substr(PHONE_FR_REGEX, 1, -1); ?>" required>
                                        <span class="form-helper <?= (isset($error['userPhone'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['userPhone'] ?? 'requis' ?></span>
                                    </div>
                                    <div class="form-field col">
                                        <label for="formCreateChild_LegalRespUserEmail">Email: </label>
                                        <input class="form-control rounded-1" type="email"
                                               id="formCreateChild_LegalRespUserEmail"
                                               name="formCreateChild_LegalRespUserEmail"
                                               value="<?= $respLegEmail ?? null; ?>"
                                               placeholder="votre.mail@mail.com"
                                               pattern="<?= substr(MAIL_REGEX, 1, -1); ?>"
                                               required>
                                        <span class="form-helper <?= (isset($error['userEmail'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['userEmail'] ?? 'requis' ?></span>
                                    </div>
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalRespPwd1">Mot de passe: </label>
                                        <input class="form-control rounded-1" autocomplete="new-password"
                                               type="password"
                                               id="formCreateChild_LegalRespPwd1" name="formCreateChild_LegalRespPwd1"
                                               pattern="<?= substr(PWD_REGEX, 1, -1); ?>" required>
                                        <span class="form-helper <?= (isset($error['Pwd1'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['Pwd1'] ?? 'requis' ?></span>
                                    </div>
                                    <div class="form-field">
                                        <label for="formCreateChild_LegalRespPwd2">Vérifier mot de passe: </label>
                                        <input class="form-control rounded-1" autocomplete="new-password"
                                               type="password"
                                               id="formCreateChild_LegalRespPwd2" name="formCreateChild_LegalRespPwd2"
                                               pattern="<?= substr(PWD_REGEX, 1, -1); ?>" required>
                                        <span class="form-helper <?= (isset($error['Pwd2'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['Pwd2'] ?? 'requis' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div id="tab2" class="grix xs1 sm2 p-2">
                                <div class="form-field">
                                    <label for="selectedRespLeg">Sélectionner un responsable légal: </label>
                                    <select class="form-control rounded-1 truncate" id="selectedRespLeg" name="selectedRespLeg">
                                        <option value="NULL" disabled="disabled" selected>--Choisissez un responsable
                                            légal--
                                        </option>
                                        <?php
                                        foreach ($arrayRespLegForCreche as $key => $value) {
                                            ?>
                                            <option value="<?= $value['parent_id']; ?>"><?= $value['lName'] . ' ' . $value['fName'] . ' (' . $value['email'] . ')'; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="rounded-1 p-0 neu-bordered neu-snow">
                        <legend>
                            <h3 class="btn cursor-default neu-snow neu-bg-darken neu-flat rounded-tr0 rounded-bl0 rounded-tl3 rounded-br3">
                                Enfant</h3></legend>
                        <div class="grix xs1 sm2 neu-convex rounded-1 p-2">
                            <div class="form-field">
                                <label for="formCreateChildGender">Genre: </label>
                                <select class="form-control rounded-1" id="formCreateChildGender"
                                        name="formCreateChildGender"
                                        placeholder="Entrer le genre" required>
                                    <?php
                                    foreach ($userGendersArray as $key => $value) {
                                        ?>
                                        <option value="<?= $value['gender_id']; ?>"
                                            <?= (isset($childGender) && $value['gender_id'] == $childGender) ? 'selected' : ''; ?>>
                                            <?php
                                            // remplace les valeur Homme par "garçon", femme par "fille"
                                            switch ($value['gender']) {
                                                case 'Homme':
                                                    echo 'Garçon';
                                                    break;
                                                case 'Femme':
                                                    echo 'Fille';
                                                    break;
                                                default:
                                                    echo $value['gender'];
                                                    break;
                                            }
                                            ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label for="formCreateChildfName">Prénom: </label>
                                <input class="form-control rounded-1" type="text" id="formCreateChildfName"
                                       name="formCreateChildfName"
                                       value="<?= $childFname ?? null; ?>" pattern="<?= substr(NAME_REGEX, 1, -1); ?>"
                                       placeholder="Entrer votre prénom" required>
                                <span class="form-helper <?= (isset($error['childfName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['childfName'] ?? 'requis' ?></span>
                            </div>
                            <div class="form-field">
                                <label for="formCreateChildlName">Nom: </label>
                                <input class="form-control rounded-1" type="text" id="formCreateChildlName"
                                       name="formCreateChildlName"
                                       value="<?= $childLname ?? null; ?>" pattern="<?= substr(NAME_REGEX, 1, -1); ?>"
                                       placeholder="Entrer votre nom" required>
                                <span class="form-helper <?= (isset($error['childlName'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['childlName'] ?? 'requis' ?></span>
                            </div>
                            <div class="form-field">
                                <label for="dateOfBirdth">Date de naissance: </label>
                                <input class="form-control rounded-1" type="date" id="dateOfBirdth" name="dateOfBirdth"
                                       value="<?= $childDateOfBirth ?? null; ?>" required>
                                <span class="form-helper <?= (isset($error['dateOfBirth'])) ? 'txt-red txt-dark-2' : ''; ?>"><?= $error['dateOfBirth'] ?? 'requis' ?></span>
                            </div>
                            <div class="form-field col-sm2">
                                <input type="hidden" id="selectedTab" name="selectedTab" value="xxx">
                                <input data-neu-click="neu-pressed" class="btn rounded-2 neu-concave mx-auto"
                                       type="submit"
                                       id="formCreateChildSubmit" name="formCreateChildSubmit" value="Ajouter"
                                    <?= (isset($error['selectedSection'])) ? 'disabled' : ''; ?>>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </main>

<?php
require '../elements/jsToast.php';
ob_start();
?>
    <script>
        //////////////////////////////////////////////////////////////////////////////////
        //|    Script pérmettant de changer la valeur d'un hidden input en fonction de |//
        //|    l'onglet actif dans la partie résponsable légal et de désactiver les    |//
        //|    inputs non visible pour ne pas bloquer l'envoie du formulaire avec le   |//
        //|    processus de validation html/javascript.                                |//
        //|____________________________________________________________________________|//
        //////////////////////////////////////////////////////////////////////////////////
        let tabAdd = document.getElementById('addRespLeg');
        let tabSelect = document.getElementById('getRespLeg');
        let divTabAdd = document.getElementById('tab1');
        let divTabSelect = document.getElementById('tab2');
        let hiddenField = document.getElementById('selectedTab');
        let inputsTabAdd = divTabAdd.querySelectorAll(".form-control");
        let inputsTabSelect = divTabSelect.querySelectorAll(".form-control");

        const config = {attributes: true};
        // Callback fonction a executer quand des mutations sont observées
        const callback = function (mutationsList, observer) {
            // Utilise une boucle traditionnel for pour IE
            for (let mutation of mutationsList) {
                if (mutation.type === 'attributes') {
                    // si des mutations ont eu lieu on attribue l'id
                    // correspondant en tant que valeur au input caché.
                    // ça permettra au controlleur de savoir si il faut
                    // ajouter un responsable légal ou simplement en
                    // séléctionner un existant
                    if (tabAdd.classList.contains('active')) {
                        hiddenField.value = tabAdd.id;
                        inputsTabSelect.forEach(
                            function (el) {
                                el.disabled = true;
                            }
                        );
                        inputsTabAdd.forEach(
                            function (el) {
                                el.disabled = false;
                            }
                        );
                    } else if (tabSelect.classList.contains('active')) {
                        hiddenField.value = tabSelect.id;
                        inputsTabAdd.forEach(
                            function (el) {
                                el.disabled = true;
                            }
                        );
                        inputsTabSelect.forEach(
                            function (el) {
                                el.disabled = false;
                            }
                        );
                    }
                    console.log(hiddenField.value);
                }
            }
        };
        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);
        // Start observing the target node for configured mutations
        observer.observe(tabAdd, config);
        ////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////


    </script>
    <script src="/assets/js/validateFormInputs.js"></script>
    </script>
<?php
$jsValidateFormInput = ob_get_clean();
?>