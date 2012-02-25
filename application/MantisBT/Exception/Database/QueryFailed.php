<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

class QueryFailed extends ExceptionAbstract {
	public function __construct($queryErrorCode, $queryErrorDescription, $queryString) {
		$errorMessage = sprintf(_('Database query failed. Error received from database was #%1$d: "%2$s" for the query: %3$s.'), $queryErrorCode, $queryErrorDescription, $queryString);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
