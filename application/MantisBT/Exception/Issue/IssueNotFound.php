<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

class IssueNotFound extends ExceptionAbstract {
	public function __construct($issueID) {
		$errorMessage = sprintf(_('Issue %1$d not found.'), $issueID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
