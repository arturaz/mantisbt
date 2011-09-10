<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RecursiveHierarchyDisallowed extends ExceptionAbstract {
	public function __construct($parentProjectID, $childProjectID) {
		$errorMessage = lang_get(ERROR_PROJECT_RECURSIVE_HIERARCHY, null, false);
		$errorMessage = sprintf($errorMessage, $parentProjectID, $childProjectID);
		parent::__construct(ERROR_PROJECT_RECURSIVE_HIERARCHY, $errorMessage, null);
		$this->responseCode = 400;
	}
}
