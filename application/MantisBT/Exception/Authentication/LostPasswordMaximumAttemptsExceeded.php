<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LostPasswordMaximumAttemptsExceeded extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LOST_PASSWORD_MAX_IN_PROGRESS_ATTEMPTS_REACHED, null, false);
		parent::__construct(ERROR_LOST_PASSWORD_MAX_IN_PROGRESS_ATTEMPTS_REACHED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
