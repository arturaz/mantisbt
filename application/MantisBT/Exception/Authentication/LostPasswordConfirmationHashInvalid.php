<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class LostPasswordConfirmationHashInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('The confirmation URL is invalid or has already been used. Please signup again.');
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
