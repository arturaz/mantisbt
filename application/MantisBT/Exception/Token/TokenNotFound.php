<?php
namespace MantisBT\Exception\Token;
use MantisBT\Exception\ExceptionAbstract;

class TokenNotFound extends ExceptionAbstract {
	public function __construct($tokenID) {
		$errorMessage = sprintf(_('Token %1$d not found.'), $tokenID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
