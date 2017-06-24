<?php

error_reporting(E_All);
session_start();
require_once("../vendor/autoload.php");
$config = parse_ini_file(__DIR__ . "/../config.ini",true);

$factory = new mangescom\Factory($config);

switch($_SERVER["REQUEST_URI"]) {
	
	//Display stuff
	case "/":
		$factory->GetBlogController()->index("Jonas' Blog");
		break;
		
	case "/blog":
		$factory->GetBlogController()->blog();
		break;	
		
	case (preg_match('/blogpost\\?id\\=\\d+/', $_SERVER["REQUEST_URI"])?true:false): {		
		$factory->GetBlogController()->blogpost($_GET["id"]);
		break;
	}
	
	case "/comment":{
		if (isset($_POST["id"])){
			$factory->GetBlogController()->comment($_POST["token"], $_POST["id"], $_POST["comment"]);
		}
		break;
	}	
		
	case "/videos":
		$factory->GetBlogController()->videos();
		break;
		
	case "/search":
		$factory->GetBlogController()->search($_POST["search"]);
		break;
		
	//User Account stuff
	case "/account":
		$cnt = $factory->GetLoginController();
		
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$cnt->showLogin("");
		}
		else {	
			$cnt->login($_POST["email"], $_POST["password"], $_POST["token"]);
		}
		break;
		
	case "/logout": {
		$factory->GetLoginController()->logout();
		break;
	}
	
	case "/changepw":{
		$cnt = $factory->GetLoginController();
		$cnt->changePW($_POST["oldPW"], $_POST["newPW"], $_POST["repPW"], $_POST["token"]);
		break;
	}
	
	case "/register": {
		$cnt = $factory->GetRegisterController();
		if($_SERVER["REQUEST_METHOD"] == "GET") {
			$cnt->showRegister();
		}
		else {
			$cnt->register($_POST["email"], $_POST["password1"], $_POST["password2"], $_POST["vorname"], $_POST["nachname"] );
		}
		break;
	}
	
	case "/forgot":{
		$cnt = $factory->GetLoginController();
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$cnt->forgot($_POST["email"]);
		}
		else {
			$cnt->showForgot();
		}
		break;
	}
	
	case (preg_match('/videoedit\\?id\\=\\d+/', $_SERVER["REQUEST_URI"])?true:false): {
		$factory->GetBlogController()->video($_GET["id"]);
		break;
	}
	
	case (preg_match('/blogedit\\?id\\=\\d+/', $_SERVER["REQUEST_URI"])?true:false): {
		$factory->GetBlogController()->post($_GET["id"]);
		break;
	}
	
	case (preg_match('/deletevideo\\?id\\=\\d+/', $_SERVER["REQUEST_URI"])?true:false): {
		$factory->GetBlogController()->deletevideo($_GET["id"]);
		break;
	}	
	
	case (preg_match('/deletepost\\?id\\=\\d+/', $_SERVER["REQUEST_URI"])?true:false): {
		$factory->GetBlogController()->deleteblog($_GET["id"]);
		break;
	}
	
	case "/postblog": {
		if(isset($_SESSION["admin"])){
			if(isset($_POST)){
				$factory->GetBlogController()->postBlog($_POST["id"], $_POST["token"], $_POST["title"], $_POST["text"], $_POST["image"]);
			}
		}
		break;
	}
	
	case "/postvideo": {
		if(isset($_SESSION["admin"])){				
			if(isset($_POST)){
				$factory->GetBlogController()->postVideo($_POST["id"], $_POST["token"], $_POST["title"], $_POST["url"]);
			}
		}
		break;
	}
	
	default:
		$factory->GetBlogController()->notFound();
}

if (($_SERVER["REQUEST_URI"]) != "/"){
	$factory->GetBlogController()->footer();
}


