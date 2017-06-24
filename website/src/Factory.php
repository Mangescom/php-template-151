<?php
namespace mangescom;

class Factory {
	private $config;
	public function __construct(array $config) {
		$this->config = $config;
	}
	
	public function GetTemplateEngine() {
		return new SimpleTemplateEngine(__DIR__ . "/../templates/");
	}
	
	public function GetRequestProtection(){
		return new RequestProtection;
	}
	
	public function GetPDO() {
		return new \PDO(
		"mysql:host=mariadb;dbname=app;charset=utf8",
		$this->config["database"]["user"],
		"my-secret-pw",
		[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
	}
	
	public function GetBlogService() {
		return new service\blog\BlogPDOService($this->GetPDO(), $this->GetTemplateEngine());
	}
	
	public function GetBlogController() {
		return new Controller\BlogController($this->GetTemplateEngine(), $this->GetBlogService(), $this->GetRequestProtection());
	}
			
	public function GetLoginService() {
		return new service\login\LoginPDOService($this->GetPDO());
	}
	
	public function GetMailer()
	{
		return \Swift_Mailer::newInstance(
				\Swift_SmtpTransport::newInstance($this->config['mailer']['host'], $this->config['mailer']['port'], $this->config['mailer']['security'])
				->setUsername($this->config['mailer']['user'])
				->setPassword($this->config['mailer']['password'])
				);
	}
	
	public function GetLoginController() {
		return new Controller\LoginController(
				$this->GetTemplateEngine(),
				$this->GetLoginService(), 
				$this->GetRequestProtection(),
				$this->GetMailer()
		);
	}

	public function GetRegisterService() {
		return new service\register\RegisterPDOService($this->GetPDO());
	}
	
	public function GetRegisterController() {
		return new Controller\RegisterController($this->GetTemplateEngine(), $this->GetRegisterService());
	}	
}
