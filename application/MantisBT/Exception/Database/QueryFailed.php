<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class QueryFailed extends ExceptionAbstract {
	public function __construct($queryErrorCode, $queryErrorDescription, $queryString) {
		$errorMessage = lang_get(ERROR_DB_QUERY_FAILED, null, false);
		$errorMessage = sprintf($errorMessage, $queryErrorCode, $queryErrorDescription, $queryString);
		parent::__construct(ERROR_DB_QUERY_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
