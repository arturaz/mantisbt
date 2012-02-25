<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class CannotModifyProtectedAccount extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('This account is protected. You are not allowed to access this until the account protection is lifted.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
