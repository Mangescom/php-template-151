<?php

namespace mangescom\Controller;

use mangescom\SimpleTemplateEngine;

class IndexController 
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

  public function homepage() {
    echo "INDEX";
  }

  public function greet($name) {
  	echo $this->template->render("hello.html.php", ["name" => $name]);
  }
}
