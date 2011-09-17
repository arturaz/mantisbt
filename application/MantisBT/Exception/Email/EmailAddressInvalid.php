<?php
namespace MantisBT\Exception\Email;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class EmailAddressInvalid extends ExceptionAbstract {
	public function __construct($invalidEmailAddress) {
		$errorMessage = lang_get(ERROR_EMAIL_INVALID, null, false);
		$errorMessage = sprintf($errorMessage, $invalidEmailAddress);
		parent::__construct(ERROR_EMAIL_INVALID, $errorMessage, null);
		$this->responseCode = 400;
	}
}
