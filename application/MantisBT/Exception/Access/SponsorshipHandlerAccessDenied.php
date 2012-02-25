<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

class SponsorshipHandlerAccessDenied extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Handler does not have the required access level to handle sponsored issues.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
