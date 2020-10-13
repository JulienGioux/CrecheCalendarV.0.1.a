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
 * Récupère l'id de la créche à effacer via $_POST
 * converti la valeur en int
 * vérifie que la valeur est bien égale à la crèche sélectionné
 * Si oui affiche message de confirmation
 */
$crecheToDelete = filter_input(INPUT_POST, 'selectedCrecheId', FILTER_SANITIZE_NUMBER_INT);
if ($crecheToDelete) {
    $crecheToDelete = filter_input(INPUT_POST, 'selectedCrecheId', FILTER_VALIDATE_INT);

    if ($crecheToDelete === $selectedCrecheId) {
        $msgConfirm = 'Etes-vous sûr de vouloir supprimer cette creche ?';
        $msgConfirm .= '<br>Si vous la supprimer vous perdrez définitivement toutes les sections, les employés,
                        les enfants ainsi que les représentants légaux qui s\'y rattachent.';
    } else {
        $error['notValidId'] = 'Crèche impossible à supprimer ou non valide';
    }
}

/**
 * Récupère l'id de la crèche à effacer après confirmation
 * Vérifie validité de la valeur et efface les entrées de la bdd
 * stock dans une variable session le nom de la crèche supprimé.
 */
$crecheConfirmedToDelete = filter_input(INPUT_POST, 'confirmDeleteCreche', FILTER_SANITIZE_NUMBER_INT);
if ($crecheConfirmedToDelete) {
    $crecheConfirmedToDelete = filter_input(INPUT_POST, 'confirmDeleteCreche', FILTER_VALIDATE_INT);
    if ($crecheConfirmedToDelete === $selectedCrecheId) {
        $_SESSION['deletedCrecheName'] = $creche->getCrecheNameById($selectedCrecheId);
        $testDelete = $creche->deleteCreche($selectedCrecheId);
        header('Location: ' . $router->generate('deleteCreche'));
        $msgConfirm = 'test';
        exit();
    }
}
/**
 * Réinitialise les valeurs de sélection et de confirmation si la suppression est effective
 * et défini un message de confirmation
 *
 */
if (isset($_SESSION['deletedCrecheName'])) {
    $msgConfirm = 'La crèche ' . $_SESSION['deletedCrecheName'] . ' et tout son contenu ont été définitivement effacé';
    unset($_SESSION['deletedCrecheName'],
        $_SESSION['UserChoices']['selectedCrecheId'],
        $selectedCrecheId,
        $selectedCrecheSectionId);
}

/**
 * Définie message d'erreur si il y en a
 */
if (isset($error)) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .= $value . '<br>';
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
                if (isset($selectedCrecheId)) :
                    ?>
                    <form method="post" action="">
                        <button type="submit" name="confirmDeleteCreche"
                                data-neu-click="neu-pressed" class="btn neu-flat rounded-1 p-2 mx-auto
                            value="<?= $crecheToDelete ?>">Supprimer</button>
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