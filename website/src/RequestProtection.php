<?php
namespace mangescom;

class RequestProtection {
		
	public function getToken()
	{
		if ($this->hasToken())
		{
			return $_SESSION["token"];
		}
		return null;
	}
	
	public function generateNewToken()
	{
		$_SESSION["token"] = bin2hex(random_bytes(8));
		return $this->getToken();
	}
	
	public function isValid(string $returnedToken)
	{
		if ($this->hasToken() && $this->getToken() == $returnedToken)
		{
			return true;
		}
		return false;
	}
	
	public function hasToken()
	{
		return isset($_SESSION["token"]);
	}
}
