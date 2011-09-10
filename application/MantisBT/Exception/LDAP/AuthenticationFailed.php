<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AuthenticationFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LDAP_AUTH_FAILED, null, false);
		parent::__construct(ERROR_LDAP_AUTH_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
