<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

class CustomFieldInvalidDefinition extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Invalid custom field definition.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
