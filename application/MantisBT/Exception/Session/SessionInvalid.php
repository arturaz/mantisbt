<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SessionInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_SESSION_NOT_VALID, null, false);
		parent::__construct(ERROR_SESSION_NOT_VALID, $errorMessage, null);
		$this->responseCode = 500;
	}
}
