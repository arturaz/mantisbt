<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

class IssueDuplicateSelf extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('You cannot set an issue as a duplicate of itself.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
