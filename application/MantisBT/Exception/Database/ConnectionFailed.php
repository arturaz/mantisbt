<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ConnectionFailed extends ExceptionAbstract {
	public function __construct($databaseErrorCode, $databaseErrorDescription) {
		$errorMessage = lang_get(ERROR_DB_CONNECT_FAILED, null, false);
		$errorMessage = sprintf($errorMessage, $databaseErrorCode, $databaseErrorDescription);
		parent::__construct(ERROR_DB_CONNECT_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
