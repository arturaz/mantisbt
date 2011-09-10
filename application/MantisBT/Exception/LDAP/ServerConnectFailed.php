<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ServerConnectFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LDAP_SERVER_CONNECT_FAILED, null, false);
		parent::__construct(ERROR_LDAP_SERVER_CONNECT_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
