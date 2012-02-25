<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class LostPasswordInvalidAccount extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('The provided information does not match any registered account!');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
