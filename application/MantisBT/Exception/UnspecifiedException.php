<?php
namespace MantisBT\Exception;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class UnspecifiedException extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_GENERIC, null, false);
		parent::__construct(ERROR_GENERIC, $errorMessage, null);
		$this->responseCode = 500;
	}
}
