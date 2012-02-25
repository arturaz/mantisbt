<?php
namespace MantisBT\Exception\Column;
use MantisBT\Exception\ExceptionAbstract;

class ColumnInvalid extends ExceptionAbstract {
	public function __construct($columnSetName, $invalidColumnName) {
		$errorMessage = sprintf(_('Field "%1$s" contains invalid field "%2$s".'), $columnSetName, $invalidColumnName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
