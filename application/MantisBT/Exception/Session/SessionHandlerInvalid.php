<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SessionHandlerInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_SESSION_HANDLER_INVALID, null, false);
		parent::__construct(ERROR_SESSION_HANDLER_INVALID, $errorMessage, null);
		$this->responseCode = 500;
	}
}
