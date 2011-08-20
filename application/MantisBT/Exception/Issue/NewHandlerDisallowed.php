<?php
namespace MantisBT\Exception\Issue;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class NewHandlerDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_USER_DOES_NOT_HAVE_REQ_ACCESS, null, false);
		parent::__construct(ERROR_USER_DOES_NOT_HAVE_REQ_ACCESS, $errorMessage, null);
		$this->responseCode = 400;
	}
}
