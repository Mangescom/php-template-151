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
			die("works");
			return true;
		}
		else {
			die("failed");
			return false;
		}
	}
	
	private function authenticate($email, $password){
		$pw = md5($password);
		$stmt = $this->pdo->prepare("SELECT id, Vorname, admin FROM user WHERE email=? AND password =?");
		$stmt->bindValue(1, $email);
		$stmt->bindValue(2, $pw);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				$_SESSION["user"] = $row[0];
				$_SESSION ["username"] = $row[1];
		
				if($row[2] == '1'){
					$_SESSION["admin"] = "Admin User";
				}
			}
			die("works");
			return true;
		}
		else {
			die("failed");
			return false;
		}
	}
}