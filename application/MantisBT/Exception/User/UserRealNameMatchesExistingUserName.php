<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserRealNameMatchesExistingUserName extends ExceptionAbstract {
	public function __construct($userRealName) {
		$errorMessage = lang_get(ERROR_USER_REAL_MATCH_USER, null, false);
		$errorMessage = sprintf($errorMessage, $userRealName);
		parent::__construct(ERROR_USER_REAL_MATCH_USER, $errorMessage, null);
		$this->responseCode = 400;
	}
}
