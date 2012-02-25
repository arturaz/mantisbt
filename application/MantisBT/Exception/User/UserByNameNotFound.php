<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserByNameNotFound extends ExceptionAbstract {
	public function __construct($userName) {
		$errorMessage = sprintf(_('User with name "%1$s" not found.'), $userName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
