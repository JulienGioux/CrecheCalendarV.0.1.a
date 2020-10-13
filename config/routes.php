<?php
$router->map('GET|POST', '/', 'home', 'home');
$router->map('GET|POST', '/home/','userHome', 'userHome');
$router->map('GET|POST', '/login-[i:logout]/', 'login', 'login');
$router->map('GET|POST', '/gestion/[*:fname]-[*:lname]/', 'gestion', 'gestion');
$router->map('GET|POST', '/page/[*:fname]-[*:lname]/','page', 'page');
$router->map('GET', '/logout/', 'logout', 'logout');
$router->map('GET', '/noAuth/', 'noAuth', 'noAuth');
$router->map('GET|POST', '/register/', 'createCrecheManager', 'register');
$router->map('GET|POST', '/addCreche/', 'createCreche', 'addCreche');
$router->map('GET|POST', '/addSection/', 'createSection', 'addSection');
$router->map('GET|POST', '/addEmployee/', 'createEmployee', 'addEmployee');
$router->map('GET|POST', '/addChild/', 'createChild', 'addChild');
$router->map('GET|POST', '/deleteCreche/', 'deleteCreche', 'deleteCreche');
$router->map('GET|POST', '/deleteSection/', 'deleteSection', 'deleteSection');
$router->map('GET|POST', '/listCrecheChilds/', 'listCrecheChilds', 'listCrecheChilds');

