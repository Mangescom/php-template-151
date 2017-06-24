<?php

namespace rohrerj\Controller;

use rohrerj\RequestProtection;
use rohrerj\SimpleTemplateEngine;
use rohrerj\service\login\LoginService;

class LoginController 
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $loginService;
  private $request;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, LoginService $loginService, RequestProtection $requestProtection)
  {
     $this->template = $template;
     $this->loginService = $loginService;
     $this->request = $requestProtection;
  }

  public function showLogin($error) {
  	echo $this->template->render("header.html.php", ["title" => "Account"]);
  	$token = $this->request->generateNewToken();
  	if(isset($_SESSION["user"])){
  		echo $this->template->render("logout.html.php");
  		
  		if(isset($_SESSION["admin"]))
  		{
  			echo "<h3 style=\"text-align:center;\">You are now logged in as ".$_SESSION["admin"]."</h3>";
  		}
  	}
  	else{
  		echo $this->template->render("login.html.php", ["error" => $error, "token" => $token]);
  	}
  }
  
  public function login($email, $password, $token) {
  	if($this->request->isValid($token))
  	{
  		$this->loginService->authenticate($email,$password);
  		header("Location: /account");
  	}
  	 
  	else{
  		echo $this->template->render("header.html.php", ["title" => "Account"]);
  		echo $this->template->render("login.html.php", ["error" => "Wrong username and password"]);
  	}
  }
  
  public function logout() {
  	if(isset($_SESSION["user"]) || isset($_SESSION["username"]) || isset($_SESSION["admin"])) {
  		session_destroy();
  	}  	
  	echo $this->template->render("header.html.php", ["title" => "Account"]);
  	echo "<h1>You are now logged out.</h1><a style='display:block; text-align:center;' href='/account'>Go back</a>";
  }
  
  public function changePW($oldPW, $newPW, $repPW, $token) {  	
  	$token = $this->request->generateNewToken();
  	if($newPW != $repPW){
  		echo $this->template->render("header.html.php", ["title" => "Account"]);
  		echo $this->template->render("logout.html.php", ["error" => "Passwords didnt match".$newPW.$repPW, "token" => $token]);
  	}
  	
  	else if($this->request->isValid($token) && $this->loginService->changePW($oldPW, $newPW, $_SESSION["user"])) {
  		echo $this->template->render("header.html.php", ["title" => "Account"]);
  		echo $this->template->render("logout.html.php", ["error" => "New Password set", "token" => $token]);
  	}
  
  	else{
  		echo $this->template->render("header.html.php", ["title" => "Account"]);
  		echo $this->template->render("logout.html.php", ["error" => "An error occured", "token" => $token]);
  	} 
  }
  public function showForgot() {
  	echo $this->template->render("header.html.php", ["title" => "Account"]);
  	echo $this->template->render("forgot.html.php");
  }
  public function forgot($mail){  
  	echo $this->template->render("header.html.php", ["title" => "Account"]);
  	echo '<h1>Password was sent if registered</h1>
  	<a style="display:block;text-align:center;" href="/account">Back to login page</a>';
  }
}
