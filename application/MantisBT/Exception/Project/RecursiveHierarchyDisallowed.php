<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

class RecursiveHierarchyDisallowed extends ExceptionAbstract {
	public function __construct($parentProjectID, $childProjectID) {
		$errorMessage = _('Project %1$d is already a child of project %2$d. To avoid creating a looped subproject hierarchy, project %3$d can not be set as a child of project %4$d.');
		$errorMessage = sprintf($errorMessage, $parentProjectID, $childProjectID, $childProjectID, $parentProjectID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
