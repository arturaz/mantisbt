<?php
namespace MantisBT\Exception\Session;
use MantisBT\Exception\ExceptionAbstract;

class SessionVariableNotFound extends ExceptionAbstract {
	public function __construct($variableName) {
		$errorMessage = sprintf(_('Session variable "%1$s" not found.'), $variableName);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
