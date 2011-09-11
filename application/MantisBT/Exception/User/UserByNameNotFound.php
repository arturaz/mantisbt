<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserByNameNotFound extends ExceptionAbstract {
	public function __construct($userName) {
		$errorMessage = lang_get(ERROR_USER_BY_NAME_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $userName);
		parent::__construct(ERROR_USER_BY_NAME_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
