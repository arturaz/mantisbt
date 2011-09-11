<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserNameNotUnique extends ExceptionAbstract {
	public function __construct($userName) {
		$errorMessage = lang_get(ERROR_USER_NAME_NOT_UNIQUE, null, false);
		$errorMessage = sprintf($errorMessage, $userName);
		parent::__construct(ERROR_USER_NAME_NOT_UNIQUE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
