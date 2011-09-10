<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LostPasswordDisabled extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LOST_PASSWORD_NOT_ENABLED, null, false);
		parent::__construct(ERROR_LOST_PASSWORD_NOT_ENABLED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
