<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SessionVariableNotFound extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = lang_get(ERROR_SESSION_VAR_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $variableName);
		parent::__construct(ERROR_SESSION_VAR_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
