<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserNameNotUnique extends ExceptionAbstract {
	public function __construct($userName) {
		$errorMessage = sprintf(_('An account already exists with user name "%1$s". Please select a unique user name.'), $userName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
