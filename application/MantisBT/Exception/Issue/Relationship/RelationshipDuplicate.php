<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RelationshipDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_RELATIONSHIP_ALREADY_EXISTS, null, false);
		parent::__construct(ERROR_RELATIONSHIP_ALREADY_EXISTS, $errorMessage, null);
		$this->responseCode = 400;
	}
}
