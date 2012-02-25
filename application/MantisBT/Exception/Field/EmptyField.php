<?php
namespace MantisBT\Exception\Field;
use MantisBT\Exception\ExceptionAbstract;

class EmptyField extends ExceptionAbstract {
	public function __construct($fieldName) {
		$errorMessage = sprintf(_('A necessary field "%1$s" was empty. Please recheck your inputs.'), $fieldName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
