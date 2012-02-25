<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

class RelationshipLoopbackDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('An issue cannot be related to itself.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
