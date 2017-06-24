<?php
namespace mangescom\service\login;

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
		$stmt = $this->pdo->prepare("SELECT password FROM user WHERE id=?");
		$stmt->bindValue(1, $id);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				if(password_verify($old, $row[0])){
					$pw = password_hash($new, PASSWORD_DEFAULT);
					$stmt = $this->pdo->prepare("ALTER user SET password=? WHERE id=?");
					$stmt->bindValue(1, $pw);
					$stmt->bindValue(2, $id);
				}
				else {
					return false;
				}
			}
		}
	}
	
	public function reset($mail, $pw){
		$stmt = $this->pdo->prepare("SELECT password FROM user WHERE email=?");
		$stmt->bindValue(1, $mail);
		$stmt->execute();
	}
	
	public function getId($mail){
		$stmt = $this->pdo->prepare("SELECT id FROM user WHERE email=?");
		$stmt->bindValue(1, $mail);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			while ($row = $stmt->fetch($this->pdo::FETCH_NUM, $this->pdo::FETCH_ORI_NEXT))
			{
				return $row[0];
			}
		}
	}
	
	public function getToken($id){
		$token = bin2hex(random_bytes(8));
		$stmt = $this->pdo->prepare("UPDATE user SET reset=? WHERE id=?");
		$stmt->bindValue(1, $token);
		$stmt->bindValue(2, $id);
		$stmt->execute();
		return $token;
	}
	
}