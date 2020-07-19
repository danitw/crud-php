<?php

require_once './config.php';

class Banco {
	private $dsn;
	private $user;
	private $passwd;
	private $pdo;

	public function __construct() {
		$this->dsn = DSN;
		$this->user = USER;
		$this->passwd = PASSWORD;

		$this->connection();
	}

	private function connection() {
		$this->pdo = $pdo = new PDO($this->dsn, $this->user, $this->passwd);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function createUser($name, $email, $password) {
		$insert = $this->pdo->prepare("insert into usuarios(name, email, password) values(?, ?, ?)");

		$insert->execute([$name, $email, $password]);

		$_SESSION['email'] = $email;
		$_SESSION['name'] = $name;
		$_SESSION['logado'] = true;
	}

	public function loginUser($em, $pass) {
		$query = $this->pdo->prepare("select * from usuarios where email=?");

		$query->execute([$em]);

		$user = $query->fetchAll(PDO::FETCH_OBJ);
		$email 		= $user[0]->email;
		$password = $user[0]->password;

		if ($email !== $em || $password !== $pass) {
			throw new Exception('Suas credenciais não correspondem no banco de dados');
		}

		$_SESSION['email'] = $email;
		$_SESSION['name'] = $user[0]->name;
		$_SESSION['logado'] = true;
	}

	public function listUsers() {
		$select = $this->pdo->prepare("select * from usuarios");
		$select->execute();

		$a = $select->fetchAll(PDO::FETCH_OBJ);

		print_r($a);
	}

	public function updateUser($id, $em, $pass, $newName, $newEmail, $newPassword) {

		$query = $this->pdo->prepare("select * from usuarios where id=?");

		$query->execute([$id]);

		$user = $query->fetchAll(PDO::FETCH_OBJ);

		$email 		= $user[0]->email;
		$password = $user[0]->password;

		if ($email !== $em || $password !== $pass) {
			throw new Exception('Suas credenciais não correspondem no banco de dados');
		}

		$update = $this->pdo->prepare("update usuarios set name = ?, email = ?, password = ? where id = ?");
		$update->execute([$newName, $newEmail, $newPassword, $id]);
	}

	public function deleteUser($id, $em, $pass) {
		$query = $this->pdo->prepare("select * from usuarios where id = ?");

		$query->execute([$id]);

		$user = $query->fetchAll(PDO::FETCH_OBJ);

		$email 		= $user[0]->email;
		$password = $user[0]->password;

		if ($email !== $em || $password !== $pass) {
			echo 3;
			throw new Exception('Suas credenciais não correspondem no banco de dados');
		}

		$delete = $this->pdo->prepare("delete from usuarios where id = :id");
		$delete->bindValue(":id", $id, PDO::PARAM_INT);
		$delete->execute();
	}

}



// 	$db->
//	$db->updateUser(1, 'twz3xc21@gmail.com', 'daniel11', 'danitw', 'danidev@gmail.com','daniel16');
//	$db->deleteUser(1, 'danidev@gmail.com', 'daniel16');
