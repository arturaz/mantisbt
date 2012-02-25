<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

class IssueReadOnly extends ExceptionAbstract {
	public function __construct($issueID) {
		$errorMessage = sprintf(_('The action cannot be performed because issue %1$d is read-only.'), $issueID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
