<?php
namespace MantisBT\Exception\GPC;
use MantisBT\Exception\ExceptionAbstract;

class ArrayExpected extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = sprintf(_('An array was expected but a string was received for parameter "%1$s".'), $variableName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
