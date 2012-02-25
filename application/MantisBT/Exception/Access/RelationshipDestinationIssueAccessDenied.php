<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

class RelationshipDestinationIssueAccessDenied extends ExceptionAbstract {
	public function __construct($destinationIssueID) {
		$errorMessage = sprintf(_('Access denied: You do not have permission to modify relationships for destination issue %1$d.'), $destinationIssueID);
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
