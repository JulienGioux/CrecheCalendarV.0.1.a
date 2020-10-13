<?php
use CrecheCalendar\Auth;
$auth = new Auth($router);
$auth->requireRole('Responsable Légal', 'Modérateur', 'Employé');
$user = $auth->user();

ob_start();
require '../controllers/controller_Nav.php';
$controller = ob_get_clean();
ob_start();
require '../elements/headerNav.php';
require '../elements/sideNav.php';
$Nav = ob_get_clean();
/**
 * Génére un message si l'utilisateur vient de se connecter
 */
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = explode('/', $_SERVER['HTTP_REFERER']);
    dump($referer);
    $refererCount = count($referer);
    if (($referer[$refererCount - 2] === 'login-0') || ($referer[$refererCount - 2] === 'login-1')) {
        $successMsg = 'Vous êtes connecté';
    }
}

?>

<div>
    <?php
    echo $_SESSION['auth']['role'] . ': ' . $user->fName . ' ' . $user->lName;
    ?>
    <button type="button" onclick="window.location.href = '<?= $router->generate('logout')?>'" class="btn rounded-1 small neu-flat neu-fresh">Se déconnecter</button>
    <a class="link" href="<?= $router->generate('gestion', ['fname' => $user->fName, 'lname' => $user->lName]); ?>">Gestion</a>
    <a class="link" href="<?= $router->generate('page', ['fname' => $user->fName, 'lname' => $user->lName]); ?>">page</a>

</div>
<?php
require '../elements/jsToast.php';
?>