<?php
session_start();
require '../vendor/autoload.php';

$router = new AltoRouter();
require '../config/routes.php';

$match = $router->match();


// appel une closure ou charge la page via mémoire tampon, sinon erreur 404
if( is_array($match)) {
    if (is_callable( $match['target'])) {
        call_user_func_array( $match['target'], $match['params'] );
    } else {
        $params = $match['params'];

        ob_start();
        require '../views/' . $match['target'] . '.php';
        $pageContent = ob_get_clean();
    }
    require '../elements/layout.php';
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
