<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

class ProjectNameNotUnique extends ExceptionAbstract {
	public function __construct($projectName) {
		$errorMessage = sprintf(_('A project already exists with the name "%1$s". Please select a unique name for this project.'), $projectName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
