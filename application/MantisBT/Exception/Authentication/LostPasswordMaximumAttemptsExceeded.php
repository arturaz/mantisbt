<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

class LostPasswordMaximumAttemptsExceeded extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Maximum number of in-progress requests reached. Please contact the system administrator.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
