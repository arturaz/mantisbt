<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class LostPasswordBlankEmail extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('You must provide an e-mail address in order to reset the password.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
