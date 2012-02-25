<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserByIDNotFound extends ExceptionAbstract {
	public function __construct($userID) {
		$errorMessage = sprintf(_('User with identifier %1$d not found.'), $userID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
