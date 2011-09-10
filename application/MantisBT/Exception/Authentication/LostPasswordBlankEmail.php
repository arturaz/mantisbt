<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LostPasswordBlankEmail extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LOST_PASSWORD_NO_EMAIL_SPECIFIED, null, false);
		parent::__construct(ERROR_LOST_PASSWORD_NO_EMAIL_SPECIFIED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
