<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

class AuthenticationFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('LDAP Authentication Failed.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
