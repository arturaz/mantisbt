<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

class SessionInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Your session has become invalidated.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
