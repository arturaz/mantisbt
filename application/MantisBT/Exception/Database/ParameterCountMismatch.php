<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

class ParameterCountMismatch extends ExceptionAbstract {
	public function __construct($queryString, array $parameters) {
		$expectedParameterCount = substr_count($queryString, '?');
		$actualParameterCount = count($parameters);
		$shortfall = $expectedParameterCount - $actualParameterCount;
		$errorMessage = n___('The parameter in the following query/statement was not provided: %2$s.', '%1$d expected parameters were not provided for the following query/statement: %2$s.', $shortfall);
		$errorMessage = sprintf($errorMessage, $shortfall, $queryString); 
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
