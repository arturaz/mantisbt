<?php
namespace MantisBT\Exception\Issue\Relationship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RelationshipLoopbackDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_RELATIONSHIP_SAME_BUG, null, false);
		parent::__construct(ERROR_RELATIONSHIP_SAME_BUG, $errorMessage, null);
		$this->responseCode = 400;
	}
}
