<?php
namespace MantisBT\Exception\LDAP;
use MantisBT\Exception\ExceptionAbstract;

class ExtensionNotLoaded extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('LDAP Extension Not Loaded.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
