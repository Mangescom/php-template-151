<?php
namespace mangescom\service\register;

interface RegisterService {
	public function register($email,$firstname,$lastname,$password);
}