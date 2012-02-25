<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

class ConnectionFailed extends ExceptionAbstract {
	public function __construct($databaseErrorCode, $databaseErrorDescription) {
		$errorMessage = sprintf(_('Database connection failed. Error received from database was #%1$d: "%2$s".'), $databaseErrorCode, $databaseErrorDescription);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
