<?php
namespace MantisBT\Exception;
use MantisBT\Exception\ExceptionAbstract;

class UnspecifiedException extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('An error occurred during this action. You may wish to report this error to your local administrator.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
