<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SignupConfirmationHashInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_SIGNUP_NOT_MATCHING_CAPTCHA, null, false);
		parent::__construct(ERROR_SIGNUP_NOT_MATCHING_CAPTCHA, $errorMessage, null);
		$this->responseCode = 403;
	}
}
