<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

class AccessDenied extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Access denied.');
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
