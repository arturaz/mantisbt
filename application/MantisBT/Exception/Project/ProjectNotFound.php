<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

class ProjectNotFound extends ExceptionAbstract {
	public function __construct($projectID) {
		$errorMessage = sprintf(_('Project %1$d not found.'), $projectID);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
