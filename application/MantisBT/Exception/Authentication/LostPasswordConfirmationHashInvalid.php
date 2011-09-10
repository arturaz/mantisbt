<?php
namespace MantisBT\Exception\Authentication;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LostPasswordConfirmationHashInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LOST_PASSWORD_CONFIRM_HASH_INVALID, null, false);
		parent::__construct(ERROR_LOST_PASSWORD_CONFIRM_HASH_INVALID, $errorMessage, null);
		$this->responseCode = 403;
	}
}
