<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class LostPasswordDisabled extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('The "lost your password" feature is not available.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
