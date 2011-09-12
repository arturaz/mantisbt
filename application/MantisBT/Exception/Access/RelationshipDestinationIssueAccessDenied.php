<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RelationshipDestinationIssueAccessDenied extends ExceptionAbstract {
	public function __construct($destinationIssueID) {
		$errorMessage = lang_get(ERROR_RELATIONSHIP_ACCESS_LEVEL_TO_DEST_BUG_TOO_LOW, null, false);
		$errorMessage = sprintf($errorMessage, $destinationIssueID);
		parent::__construct(ERROR_RELATIONSHIP_ACCESS_LEVEL_TO_DEST_BUG_TOO_LOW, $errorMessage, null);
		$this->responseCode = 403;
	}
}
