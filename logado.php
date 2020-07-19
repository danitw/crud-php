<?php  
session_start();

if ($_SESSION['logado'] === null || $_SESSION['logado'] === false) {
	header('Location: login.html');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
</head>
<body>
	<h1>Você está logado <?= $_SESSION['name']?></h1>

	<form method="POST" action="logout.php">
		<button type="submit">LOGOUT</button>
	</form>
</body>
</html>

