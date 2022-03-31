<?php

$db = new PDO('sqlite:' . __DIR__ . '/database.db');
$db->exec(file_get_contents(__DIR__ . '/config.sql'));

//get user with admin role
$query = $db->prepare('SELECT * FROM users WHERE role = "admin"');
$query->execute();
$admin = $query->fetch();

if(!$admin)
{
    $db->exec("INSERT INTO users (username, email, password, role) VALUES ('admin', 'pablobo@icloud.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 'admin')");
}