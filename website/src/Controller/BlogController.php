<?php

namespace rohrerj\Controller;

use rohrerj\RequestProtection;
use rohrerj\SimpleTemplateEngine;
use rohrerj\service\blog\BlogService;

class BlogController
{
  /**
   * @var ihrname\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  private $blogService;
  private $request;
  
  /**
   * @param ihrname\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template, BlogService $blogService, RequestProtection $requestProtection) {
  	$this->template = $template;
    $this->blogService = $blogService;
    $this->request = $requestProtection;
  }
	
  //-------------------DISPLAY STUFF------------------------------------------------------------
  public function index($title) {
 	echo $this->template->render("index.html.php", ["title" => $title]);
  }
  
  
  public function main($title) {
  	echo $this->template->render("header.html.php", ["title" => $title]);
  }
  
  public function footer() {
  	echo $this->template->render("footer.html.php");
  }
  
  public function blog() {
  	echo $this->main("Blog");  
  	if(isset($_SESSION["admin"]))
  	{
  		echo "<a href=\"/blogedit?id=0\">Add new Blogpost</a>";
  	}  	
  	$this->blogService->ShowBlog();
  }
  
  public function search($searchterm) {
  	echo $this->main("Search: ".$searchterm);
  	$this->blogService->SearchPosts($searchterm);
  }
  
  public function videos() {  	
  	echo $this->main("Videos");
  	if(isset($_SESSION["admin"]))
  	{
  		echo "<a href=\"/videoedit?id=0\">Add new Video</a>";
  	}  	
  	$this->blogService->ShowVideo();  	
  } 
  
  public function blogpost($id) {
  	$this->blogService->ShowPost($id);
  	$this->blogService->ShowComments($id);
  	if (isset($_SESSION["user"]))
  	{
  		echo $this->template->render("comment.html.php",["id" => $id, "token" => $this->request->generateNewToken()]);
  	}
  }
  
  public function comment($token, $id, $comment) {
  	if($this->request->isValid($token) && $this->blogService->PostComment($id, $comment)){
  		header("Location: /blogpost?id=".$id);
  	}
  	else{
  		$this->main("Error");
  		echo "<h3>Error while posting</h3>";
  	}
  }  
  //-------------------POST/EDIT STUFF------------------------------------------------------------
  public function postVideo($id, $token, $title, $url){
  	if($this->request->isValid($token))
  	{
  		if($id == 0 ){
  			if($this->blogService->PostVideo($id, $title, $url)){
  				header("Location: /videos");
  			}
  		}
  		else if($this->blogService->PostVideo($id, $title, $url)){
  			header("Location: /videos");
  		}
  	}
  	else{
  		$this->main("Error");
  		echo "<h3>Error while posting</h3>";
  		echo $id.$token.$title.$url;
  	}
  }
  
  public function postBlog($id, $token, $title, $text, $image){
  	if($this->request->isValid($token))
  	{
  		if($id == 0 && (	strpos($image, '.jpg') || strpos($image, '.png')	)){
  			if($this->blogService->PostBlog($id, $title, $text, $image)){
  				header("Location: /blog");
  			}
  		}
  		else if(strpos($image, '.jpg') || strpos($image, '.png')){
  			if($this->blogService->PostBlog($id, $title, $text, $image)){
  				header("Location: /blog");
  			}
  		}
  		else{
  			echo "Here";
  			$this->main("Error");
  			echo "<h3>Error while posting</h3>";
  		}
  	}
  	
  	else{
		echo "Here";
  		$this->main("Error");
  		echo "<h3>Error while posting</h3>";
  	}
  }
  
  public function video($id) {
  	$token = $this->request->generateNewToken();
  	echo $this->main("video");  	
  	if($id == 0){
  		echo $this->template->render("videoedit.html.php",
  				[
  						"id" => $id, 
  						"title" => "", 
  						"url"=> "",
  						"token"	=> $token
  						
  				]);
  	}
  	else {
		$this->blogService->EditVideo($id, $token);
  	}
  }
  
  public function post($id) {
  	echo $this->main("Blog");
  	$token = $this->request->generateNewToken();
  	if($id == 0){  		
  		echo $this->template->render("blogedit.html.php",
  				[
  						"id" 	=> $id, 
  						"title" => "", 
  						"url"	=> "",
  						"token"	=> $token
  						
  				]);
  	}
  	else {
  		$this->blogService->EditBlog($id, $token);
  	}
  }
  //-------------------DELETE STUFF------------------------------------------------------------
  public function deletevideo($id){
  	if($id==0){
  		header("Location: /videos");
  	}
  	else if($this->blogService->DeleteVideo($id)){
  		header("Location: /videos");
  	}
  	else{
  		$this->main("Error");
  		echo "<h3>Error while deleting</h3>";
  		echo $id.$token.$title.$url;
  	}
  } 
  
  public function deleteblog($id){
  	if($id==0){
  		header("Location: /blog");
  	}
  	else if($this->blogService->DeleteBlog($id)){
  		header("Location: /blog");
  	}
  	else{
  		$this->main("Error");
  		echo "<h3>Error while deleting</h3>";
  	}
  } 
  
  public function notFound(){
  	echo $this->main("404: Not found");
  	echo $this->template->render("notFound.html.php");
  }
}
