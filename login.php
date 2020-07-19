<?php
session_start();

require_once './banco.php';

$email 		= $_POST['email'];
$password = $_POST['password'];

$db = new Banco();

$db->loginUser($email, $password);

header('Location: logado.php');