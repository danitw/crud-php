<?php
class Banco {
	private $dsn;
	private $user;
	private $passwd;
	private $pdo;

	public function __construct($dsn, $user, $passwd) {
		$this->dsn = $dsn;
		$this->user = $user;
		$this->passwd = $passwd;
	}

	public function conectar() {
		$this->pdo = $pdo = new PDO($this->dsn, $this->user, $this->passwd);
	}

	public function authenticateUser() {

	}

	public function createUser($name, $email, $password) {
		$insert = $this->pdo->prepare("insert into usuarios(name, email, password) values(?, ?, ?)");

		$insert->execute([$name, $email, $password]);
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

$dsn 		= 'pgsql:host=localhost;port=5432;dbname=sistema-login';
$user 	= 'postgres';
$passwd = 'docker';

$db = new Banco($dsn, $user, $passwd);

$db->conectar();

$db->deleteUser(1, 'danidev@gmail.com', 'daniel16');
// $db->updateUser(1, 'twz3xc21@gmail.com', 'daniel11', 'danitw', 'danidev@gmail.com','daniel16');
