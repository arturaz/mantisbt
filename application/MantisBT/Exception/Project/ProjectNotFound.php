<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ProjectNotFound extends ExceptionAbstract {
	public function __construct($projectID) {
		$errorMessage = lang_get(ERROR_PROJECT_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $projectID);
		parent::__construct(ERROR_PROJECT_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
