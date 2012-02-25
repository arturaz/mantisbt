<?php
namespace MantisBT\Exception\GPC;
use MantisBT\Exception\ExceptionAbstract;

class NumberExpected extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = sprintf(_('A number was expected for parameter "%1$s".'), $variableName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
