<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

class RelationshipNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Relationship not found.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
