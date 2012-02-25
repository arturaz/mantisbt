<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

class CustomFieldNotFound extends ExceptionAbstract {
	public function __construct($fieldID) {
		$errorMessage = sprintf(_('Custom field %1$d not found.'), $fieldID);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
