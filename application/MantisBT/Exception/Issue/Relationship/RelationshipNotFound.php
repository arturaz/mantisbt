<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RelationshipNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_RELATIONSHIP_NOT_FOUND, null, false);
		parent::__construct(ERROR_RELATIONSHIP_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
