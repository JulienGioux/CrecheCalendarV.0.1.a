<?php
ob_start();
require '../controllers/controller_Nav.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();

$messageError='Vous n\'avez pas les droits nécéssaires pour accéder à cette page.';
?>
<main class=" vself-center card shadow-1 m-3">

        <div class="card-header neu-blue"><i class="fas fa-times-circle mx-2"></i>Permission refusé !</div>
        <div class="divider"></div>
        <div class="card-content">
            <p class="txt-center txt-red txt-dark-1">
            <?= $messageError?>
                <br>Veuillez contacter votre administrateur ou utiliser un compte approprié.
            </p>
        </div>
        <div class="divider"></div>
        <div class="card-footer neu-blue">
            <a href="<?= $router->generate('login', ['logout' => 0]) ?>"
               data-neu-click="neu-pressed" class="btn neu-flat rounded-1 p-2 mx-auto">Se connecter</a>
        </div>

</main>
<?php
require '../elements/jsToast.php';
?>