<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserPasswordMismatch extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_USER_CREATE_PASSWORD_MISMATCH, null, false);
		parent::__construct(ERROR_USER_CREATE_PASSWORD_MISMATCH, $errorMessage, null);
		$this->responseCode = 400;
	}
}
