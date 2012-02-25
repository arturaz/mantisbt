<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

class CustomFieldInvalidValue extends ExceptionAbstract {
	public function __construct($fieldName) {
		$errorMessage = sprintf(_('Invalid value for field "%1$s".'), $fieldName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
