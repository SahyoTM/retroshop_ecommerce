<?php

//session
session_start();

//include_once 'src/database/database.php';
include_once 'src/Router.php';

//use the Router to add the Controller Test and the method index
$router = new Router($_GET['url']);

$router->add('/', 'HomeController', 'index', 'GET');
$router->add('/search', 'HomeController', 'search', 'POST');

$router->add('/register', 'RegisterController', 'index', 'GET');
$router->add('/register', 'RegisterController', 'register', 'POST');

$router->add('/login', 'LoginController', 'index', 'GET');
$router->add('/login', 'LoginController', 'login', 'POST');

$router->add('/logout', 'LogoutController', 'index', 'GET');

$router->add('/admin-product', 'AdminProductController', 'index', 'GET');
$router->add('/admin-product/add', 'AdminProductController', 'add', 'POST');
$router->add('/admin-product/delete', 'AdminProductController', 'delete', 'POST');
$router->add('/admin-product/edit', 'AdminProductController', 'edit', 'POST');

$router->add('/admin-category', 'AdminCategoryController', 'index', 'GET');
$router->add('/admin-category/add', 'AdminCategoryController', 'add', 'POST');
$router->add('/admin-category/delete', 'AdminCategoryController', 'delete', 'POST');

$router->add('/admin-user', 'AdminUserController', 'index', 'GET');
$router->add('/admin-user/add', 'AdminUserController', 'add', 'POST');
$router->add('/admin-user/role', 'AdminUserController', 'role', 'POST');
$router->add('/admin-user/delete', 'AdminUserController', 'delete', 'POST');

$router->add('/user-profil', 'UserProfilController', 'index', 'GET');
$router->add('/user-profil/edit', 'UserProfilController', 'edit', 'POST');

$router->match();