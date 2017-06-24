<?php
namespace rohrerj\service\login;

class LoginPDOService implements LoginService {
	
	private $pdo;
	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;	
	}
	
	public function authenticate($username, $password){
		$stmt = $this->pdo->prepare("SELECT id, Vorname, password, admin FROM user WHERE email=?");
		$stmt->bindValue(1, $username);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				$_SESSION["user"] = $row[0];
				$_SESSION ["username"] = $row[1];		
				
				if($row[3] == '1'){
					$_SESSION["admin"] = "Admin User";
				}
			}
			if(password_verify($password, $row[2])){
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	
	public function changepw($old,$new,$id){
		$pw = md5($old);
		$newpw = md5($new);
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE id=? AND password =?");
		$stmt->bindValue(1, $id);
		$stmt->bindValue(2, $pw);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
				$stmt2 = $this->pdo->prepare("UPDATE user SET password=? WHERE id=?");
				$stmt2->bindValue(1, $newpw);
				$stmt2->bindValue(2, $id);
				$stmt2->execute();
				return true;
		}
		else {
			return false;
		}
	}
	
	public function reset($mail, $pw){
		$pass = md5($pw);
		$stmt = $this->pdo->prepare("SELECT * FROM user WHERE email=?");
		$stmt->bindValue(1, $mail);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$stmt2 = $this->pdo->prepare("UPDATE user SET password=? WHERE email=?");
			$stmt2->bindValue(1, $pass);
			$stmt2->bindValue(2, $mail);
			$stmt2->execute();
		}
	}
}