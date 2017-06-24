<?php
namespace rohrerj\service\login;

interface LoginService {
	public function authenticate($username,$password);
	public function changepw($old,$new,$mail);
	public function reset($mail, $pw);
}


