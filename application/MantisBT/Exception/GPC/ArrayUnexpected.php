<?php
namespace MantisBT\Exception\GPC;
use MantisBT\Exception\ExceptionAbstract;

class ArrayUnexpected extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = sprintf(_('A string was expected but an array was received for parameter "%1$s".'), $variableName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
