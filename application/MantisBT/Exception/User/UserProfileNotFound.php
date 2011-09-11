<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UserProfileNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_USER_PROFILE_NOT_FOUND, null, false);
		parent::__construct(ERROR_USER_PROFILE_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
