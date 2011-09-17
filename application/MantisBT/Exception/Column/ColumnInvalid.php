<?php
namespace MantisBT\Exception\Column;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ColumnInvalid extends ExceptionAbstract {
	public function __construct($columnSetName, $invalidColumnName) {
		$errorMessage = lang_get(ERROR_COLUMNS_INVALID, null, false);
		$errorMessage = sprintf($errorMessage, $columnSetName, $invalidColumnName);
		parent::__construct(ERROR_COLUMNS_INVALID, $errorMessage, null);
		$this->responseCode = 400;
	}
}
