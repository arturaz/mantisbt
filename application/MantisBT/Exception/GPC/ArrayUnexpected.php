<?php
namespace MantisBT\Exception\GPC;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ArrayUnexpected extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = lang_get(ERROR_GPC_ARRAY_UNEXPECTED, null, false);
		$errorMessage = sprintf($errorMessage, $variableName);
		parent::__construct(ERROR_GPC_ARRAY_UNEXPECTED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
