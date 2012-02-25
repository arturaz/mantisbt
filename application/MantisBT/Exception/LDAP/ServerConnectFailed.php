<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

class ServerConnectFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('LDAP Server Connection Failed.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
