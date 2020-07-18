<?php

require_once './banco.php';

$email = $_POST['email'];
$password = $_POST['password'];

$db = new Banco();

$db->loginUser($email, $password);