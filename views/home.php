<?php
ob_start();
require '../controllers/controller_Nav.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
?>
<main class="mx-auto vself-center card shadow-1 m-3">
    <div class="card-header neu-blue"><i class="fas fa-bug mx-2"></i>Site en construction !</div>
    <div class="divider"></div>
    <div class="card-content">
        <p class="txt-center txt-red txt-dark-1">
            Ce site est actuellement en construction et à l'usage unique de son développeur qui se
            trouve être désolé pour la gène occasionné.
        </p>
    </div>
    <div class="divider"></div>
    <div class="card-footer neu-blue">
        <a href="<?= $router->generate('login', ['logout' => 0]) ?>"
           data-neu-click="neu-pressed" class="btn neu-flat rounded-1 p-2 mx-auto">Se connecter</a>
    </div>
</main>