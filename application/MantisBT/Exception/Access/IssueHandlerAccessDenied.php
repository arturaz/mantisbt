<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class IssueHandlerAccessDenied extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_HANDLER_ACCESS_TOO_LOW, null, false);
		parent::__construct(ERROR_HANDLER_ACCESS_TOO_LOW, $errorMessage, null);
		$this->responseCode = 400;
	}
}
