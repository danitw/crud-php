<?php

require_once './banco.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$db = new Banco();

$db->createUser($name, $email, $password);
