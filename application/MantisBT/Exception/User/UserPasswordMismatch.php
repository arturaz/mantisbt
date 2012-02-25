<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserPasswordMismatch extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Password does not match verification.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
