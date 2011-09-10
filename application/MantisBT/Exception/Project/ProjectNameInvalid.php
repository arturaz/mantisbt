<?php
namespace MantisBT\Exception\Project;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ProjectNameInvalid extends ExceptionAbstract {
	public function __construct($projectName) {
		$errorMessage = lang_get(ERROR_PROJECT_NAME_INVALID, null, false);
		$errorMessage = sprintf($errorMessage, $projectName);
		parent::__construct(ERROR_PROJECT_NAME_INVALID, $errorMessage, null);
		$this->responseCode = 400;
	}
}
