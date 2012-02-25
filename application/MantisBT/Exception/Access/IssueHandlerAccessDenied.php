<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

class IssueHandlerAccessDenied extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Issue handler does not have sufficient access rights to handle issue at this status.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
