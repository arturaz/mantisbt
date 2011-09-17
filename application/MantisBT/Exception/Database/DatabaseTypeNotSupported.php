<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class DatabaseTypeNotSupported extends ExceptionAbstract {
	public function __construct($databaseType) {
		/* TODO: add new language string */
		$errorMessage = lang_get(ERROR_GENERIC, null, false);
		$errorMessage = sprintf($errorMessage, $databaseType);
		/* TODO: assign new error code instead of 0 */
		parent::__construct(0, $errorMessage, null);
		$this->responseCode = 500;
	}
}
