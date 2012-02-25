<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

class ProjectNameInvalid extends ExceptionAbstract {
	public function __construct($projectName) {
		$errorMessage = sprintf(_('Invalid project name "%1$s" specified. Project names cannot be blank.'), $projectName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
