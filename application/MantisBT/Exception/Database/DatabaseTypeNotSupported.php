<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

class DatabaseTypeNotSupported extends ExceptionAbstract {
	public function __construct($databaseType) {
		$errorMessage = sprintf(_('This PHP installation has not been configured to support the requested "%1$s" database type.', $databaseType));
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
