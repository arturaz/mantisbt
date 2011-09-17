<?php
namespace MantisBT\Exception\Column;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ColumnDuplicate extends ExceptionAbstract {
	public function __construct($columnSetName, $duplicateColumnName) {
		$errorMessage = lang_get(ERROR_COLUMNS_DUPLICATE, null, false);
		$errorMessage = sprintf($errorMessage, $columnSetName, $duplicateColumnName);
		parent::__construct(ERROR_COLUMNS_DUPLICATE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
