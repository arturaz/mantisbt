<?php
namespace MantisBT\Exception\Column;
use MantisBT\Exception\ExceptionAbstract;

class ColumnDuplicate extends ExceptionAbstract {
	public function __construct($columnSetName, $duplicateColumnName) {
		$errorMessage = sprintf(_('Field "%1$s" contains duplicate column "%2$s".'), $columnSetName, $duplicateColumnName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
