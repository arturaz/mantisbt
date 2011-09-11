<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserByIDNotFound extends ExceptionAbstract {
	public function __construct($userID) {
		$errorMessage = lang_get(ERROR_USER_BY_ID_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $userID);
		parent::__construct(ERROR_USER_BY_ID_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
