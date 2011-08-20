<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ColumnNotFound extends ExceptionAbstract {
	public function __construct($columnName) {
		$errorMessage = lang_get(ERROR_DB_FIELD_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $columnName);
		parent::__construct(ERROR_DB_FIELD_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
