<?php

session_destroy();
session_start();
header('Location: ' . $router->generate('login', ['logout' => 1]));