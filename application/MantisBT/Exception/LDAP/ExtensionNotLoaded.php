<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ExtensionNotLoaded extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_LDAP_EXTENSION_NOT_LOADED, null, false);
		parent::__construct(ERROR_LDAP_EXTENSION_NOT_LOADED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
