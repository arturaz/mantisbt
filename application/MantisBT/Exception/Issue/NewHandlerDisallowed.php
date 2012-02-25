<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

class NewHandlerDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('The handler specified does not have permission to handle this issue.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
