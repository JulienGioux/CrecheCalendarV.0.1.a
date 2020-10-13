<?php
$boolConnected = (isset($_SESSION['auth']['id']));
if ($boolConnected) {
    $role = $_SESSION['auth']['role'];
}

?>
<header>
    <nav class="navbar neu-blue dark-2 shadow-2 lh-6">
        <a href="<?= $router->generate('userHome') ?>" class="navbar-logo px-4 lh-4 rounded-3 centered">
            <img class="v-center d-inline-block"
                 src="/assets/img/logos/crechecalendar_logo_white_200x200.png" alt="CrecheCalendar Logo">
            <span class="logoFont textshadow-2 FontSize2rem hide-sm-down">CrecheCalendar</span>
            <small class="lh-rem-4 ml-2">v0.1a</small>
        </a>

        <button data-target="main-sidenav" class="sidenav-trigger btn rounded-1 small hide-md-up hide-xs neu-concave">
            <i class="fas fa-bars"></i> Menu
        </button>
        <button data-target="main-sidenav" class="sidenav-trigger btn shadow-1 circle hide-sm-up neu-concave">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-menu hide-sm-down">
            <a class="navbar-link neu-flat neu-lighten rounded-2 mx-1" data-neu-click="neu-pressed"
               href="<?= $router->generate('home') ?>"><i class="fas fa-home"></i> Home</a>
            <?php if (!$boolConnected): ?>
                <a class="navbar-link neu-flat neu-lighten rounded-2 mx-1" data-neu-click="neu-pressed"
                   href="<?= $router->generate('register') ?>"><i class="fas fa-user-shield"></i> S'enregister </a>
            <?php endif; ?>
            <a class="navbar-link neu-flat neu-lighten rounded-2 mx-1" data-neu-click="neu-pressed"
               href="<?= $router->generate(($boolConnected) ? 'logout' : 'login', ['logout' => 0]) ?>"><i
                        class="fas fa-key"></i> <?= ($boolConnected) ? 'Déconnexion' : 'Se connecter'; ?></a>
        </div>
        <div class="navbar-menu ml-auto">
            <a class="navbar-link" id="github" href="https://github.com/axentix/axentix" target="_blank" rel="noopener"><i
                        class="fab fa-github"></i><span class="hide-xs"> GITHUB</span></a>
            <a class="navbar-link" id="twitter" href="https://twitter.com/UseAxentix" target="_blank" rel="noopener"><i
                        class="fab fa-twitter"></i></a>
        </div>
    </nav>

</header>