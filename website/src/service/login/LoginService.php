<?php
namespace mangescom\service\login;

interface LoginService {
	public function authenticate($username,$password);
	public function changepw($old,$new,$mail);
	public function reset($mail, $pw);
	public function getId($mail);
	public function getToken($id);
}


