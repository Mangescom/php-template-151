<?php
namespace rohrerj\Controller;

use rohrerj\SimpleTemplateEngine;
use rohrerj\service\register\RegisterService;

class RegisterController {
	
	private $template;
	private $registerService;
	
	public function __construct(SimpleTemplateEngine $template, RegisterService $registerService)
	{
		$this->template = $template;
		$this->registerService = $registerService;
	}
	
	public function showRegister($error = "") {
		echo $this->template->render("header.html.php", ["title" => "Account"]);
		echo $this->template->render("register.html.php", ["error" => $error]);
	}
	
	public function register($email, $password1, $password2, $vorname, $nachname) {
		/*if(isset($email)) {
			$this->showRegister("Fill out all the fields");
		}
		else*/ if($password1 != $password2) {
			$this->showRegister("Passwords didnt match");
		}
		else {
			echo $this->template->render("header.html.php", ["title" => "Account"]);
			if($this->registerService->register($email, $vorname, $nachname, $password1)) {
				echo $this->template->render("logout.html.php");
			}
			else {
				echo $this->template->render("register.html.php", ["error" => "An error has occured"]);
			}
		}
	}
}