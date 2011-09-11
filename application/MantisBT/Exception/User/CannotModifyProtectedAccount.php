<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class CannotModifyProtectedAccount extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_PROTECTED_ACCOUNT, null, false);
		parent::__construct(ERROR_PROTECTED_ACCOUNT, $errorMessage, null);
		$this->responseCode = 400;
	}
}
