<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

class DependantIssuesNotResolved extends ExceptionAbstract {
	public function __construct($issueID) {
		$errorMessage = _('This issue cannot be resolved until all dependant issues have been resolved.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
