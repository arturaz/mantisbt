<?php
namespace MantisBT\Exception\Token;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TokenNotFound extends ExceptionAbstract {
	public function __construct($tokenID) {
		$errorMessage = lang_get(ERROR_TOKEN_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $tokenID);
		parent::__construct(ERROR_TOKEN_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
