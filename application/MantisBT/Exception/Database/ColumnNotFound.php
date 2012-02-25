<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

class ColumnNotFound extends ExceptionAbstract {
	public function __construct($columnName) {
		$errorMessage = sprintf(_('A column named "%1$s" was not found in the selected database table.'), $columnName);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
