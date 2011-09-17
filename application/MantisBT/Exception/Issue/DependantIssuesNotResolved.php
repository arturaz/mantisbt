<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class DependantIssuesNotResolved extends ExceptionAbstract {
	public function __construct($issueID) {
		$errorMessage = lang_get(ERROR_BUG_RESOLVE_DEPENDANTS_BLOCKING, null, false);
		$errorMessage = sprintf($errorMessage, $issueID);
		parent::__construct(ERROR_BUG_RESOLVE_DEPENDANTS_BLOCKING, $errorMessage, null);
		$this->responseCode = 400;
	}
}
