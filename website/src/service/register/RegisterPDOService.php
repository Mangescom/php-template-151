<?php
namespace mangescom\service\register;

class RegisterPDOService implements RegisterService {

	private $pdo;
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function register($email,$firstname,$lastname, $password){
		if($this->userNotExist($email)) {
			if($this->createUser($email,$firstname,$lastname,$password)) {
				if($this->authenticate($email, $password)){
					return true;					
				}
			}
		}
	}
	private function userNotExist($email) {
		$stmt = $this->pdo->prepare("SELECT email FROM user WHERE email=?");
		$stmt->bindValue(1, $email);
		$stmt->execute();
		if($stmt->rowCount() == 0) {
			return true;
		}
		else {
			return false;
		}
	}
	private function createUser($email,$firstname,$lastname,$password) {
		//$pw = md5($password);
		$pw = password_hash($password, PASSWORD_DEFAULT);
		$stmt = $this->pdo->prepare("INSERT INTO user(email,vorname,nachname,password) VALUES(?,?,?,?)");
		$stmt->bindValue(1, $email);
		$stmt->bindValue(2, $firstname);
		$stmt->bindValue(3, $lastname);
		$stmt->bindValue(4, $pw);
		if($stmt->execute()) {
			header("Location: /account");
		}
		else {
			return false;
		}
	}
}