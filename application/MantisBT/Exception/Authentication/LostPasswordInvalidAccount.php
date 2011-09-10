<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LostPasswordInvalidAccount extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LOST_PASSWORD_NOT_MATCHING_DATA, null, false);
		parent::__construct(ERROR_LOST_PASSWORD_NOT_MATCHING_DATA, $errorMessage, null);
		$this->responseCode = 400;
	}
}
