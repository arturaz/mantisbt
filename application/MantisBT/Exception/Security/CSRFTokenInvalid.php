<?php
namespace MantisBT\Exception\Security;
use MantisBT\Exception\ExceptionAbstract;

class CSRFTokenInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Invalid form security token. Did you submit the form twice by accident?');
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
