<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

class CustomFieldNameNotUnique extends ExceptionAbstract {
	public function __construct($fieldName) {
		$errorMessage = sprintf(_('A custom field named "%1$s" already exists. Duplicate custom field names are not allowed.'), $fieldName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
