<?php
use CrecheCalendar\Auth;

$auth = new Auth($router);
$auth->requireRole('Modérateur');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
/**
 * Récupère l'id de la Section à effacer via $_POST
 * converti la valeur en int
 * vérifie que la valeur est bien égale à la section sélectionné
 * Si oui affiche message de confirmation
 */
$sectionToDelete = filter_input(INPUT_POST, 'selectedSectionId', FILTER_SANITIZE_NUMBER_INT);
if ($sectionToDelete) {
    $sectionToDelete = filter_input(INPUT_POST,'selectedSectionId', FILTER_VALIDATE_INT);

    if ($sectionToDelete === $selectedCrecheSectionId) {
        $msgConfirm = 'Etes-vous sûr de vouloir supprimer cette section ?';
        $msgConfirm .= '<br>Si vous la supprimer vous perdrez définitivement tous les employés,
                        les enfants ainsi que les représentants légaux qui s\'y rattachent.';
    } else {
        $error['notValidId'] = 'section impossible à supprimer ou non valide';
    }
}

/**
 * Récupère l'id de la section à effacer après confirmation
 * Vérifie validité de la valeur et efface les entrées de la bdd
 * stock dans une variable session le nom de la section supprimé.
 */
$sectionConfirmedToDelete = filter_input(INPUT_POST, 'confirmDeleteSection', FILTER_SANITIZE_NUMBER_INT);
if ($sectionConfirmedToDelete) {
    $sectionConfirmedToDelete = filter_input(INPUT_POST,'confirmDeleteSection', FILTER_VALIDATE_INT);
    if ($sectionConfirmedToDelete === $selectedCrecheSectionId) {
        $_SESSION['deletedSectionName'] = $crecheSection->getSectionById($selectedCrecheSectionId)['section_Name'];
        $testDelete = $crecheSection->deleteSection($selectedCrecheSectionId);
        header('Location: '. $router->generate('deleteSection'));
        $msgConfirm = 'test';
        exit();
    }
}
/**
 * Réinitialise les valeurs de sélection et de confirmation si la suppression est effective
 * et défini un message de confirmation
 *
 */
if (isset($_SESSION['deletedSectionName'])) {
    $msgConfirm = 'La crèche ' . $_SESSION['deletedSectionName'] . ' et tout son contenu ont été définitivement effacé';
    unset($_SESSION['deletedSectionName'],
        $_SESSION['UserChoices']['selectedCrecheSectionId'],
        $selectedCrecheSectionId);
}

/**
 * Définie message d'erreur si il y en a
 */
if (isset($error)) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .=  $value . '<br>';
    }
}
?>

    <main class="vself-center card shadow-1 m-3">
        <?php
        if (isset($msgConfirm)) :
            ?>
            <div class="card-header neu-blue"><i class="fas fa-times-circle mx-2"></i>Attention !</div>
            <div class="divider"></div>
            <div class="card-content">
                <p class="txt-center txt-red txt-dark-1">
                    <?= $msgConfirm ?>
                </p>
            </div>
            <div class="divider"></div>
            <div class="card-footer neu-blue">
                <?php
                if (isset($selectedCrecheSectionId)) :
                    ?>
                    <form method="post" action="">
                        <button type="submit" name="confirmDeleteSection" value="<?= $sectionToDelete ?>">Supprimer</button>
                    </form>
                <?php
                endif;
                ?>

            </div>
        <?php
        endif;
        ?>
    </main>

<?php
require '../elements/jsToast.php';
ob_start();
?>
    <script src="/assets/js/validateFormInputs.js"></script>
<?php
$jsValidateFormInput = ob_get_clean();
?>