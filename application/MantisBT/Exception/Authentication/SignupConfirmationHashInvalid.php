<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class SignupConfirmationHashInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Confirmation hash does not match. Please retry.');
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
