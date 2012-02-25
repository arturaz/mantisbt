<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

class SessionHandlerInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Invalid session handler.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
