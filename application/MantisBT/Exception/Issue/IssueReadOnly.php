<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class IssueReadOnly extends ExceptionAbstract {
	public function __construct($issueID) {
		$errorMessage = lang_get(ERROR_BUG_READ_ONLY_ACTION_DENIED, null, false);
		$errorMessage = sprintf($errorMessage, $issueID);
		parent::__construct(ERROR_BUG_READ_ONLY_ACTION_DENIED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
