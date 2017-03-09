<?php

namespace mangescom\Controller;

use mangescom\SimpleTemplateEngine;

class LoginController 
{
  /**
   * @var mangescom\SimpleTemplateEngine Template engines to render output
   */
  private $template;
  
  /**
   * @param mangescom\SimpleTemplateEngine
   */
  public function __construct(SimpleTemplateEngine $template)
  {
     $this->template = $template;
  }

  public function login(){
  	echo $this->template->render("login.html.php");
  }
}
