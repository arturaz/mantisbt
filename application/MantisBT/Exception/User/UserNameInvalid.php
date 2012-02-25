<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserNameInvalid extends ExceptionAbstract {
	public function __construct($userName) {
		$errorMessage = sprintf(_('The user name "%1$s" is invalid. User names may only contain Latin letters, numbers, spaces, hyphens, dots, plus signs and underscores.'), $userName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
