<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

class RelationshipDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('There is already a relationship between these two issues.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
