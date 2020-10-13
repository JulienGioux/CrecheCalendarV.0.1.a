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
?>
<a class="link" href="<?= $router->generate('addCreche') ?>">+ Crèche</a>
