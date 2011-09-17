<?php
namespace MantisBT\Exception\Database;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ParameterCountMismatch extends ExceptionAbstract {
	public function __construct($queryString, array $parameters) {
		$expectedParameterCount = substr_count($queryString, '?');
		$actualParameterCount = count($parameters);
		/* TODO: add new language string */
		$errorMessage = lang_get(ERROR_GENERIC, null, false);
		$errorMessage = sprintf($errorMessage, $expectedParameterCount, $actualParameterCount, $queryString);
		/* TODO: assign new error code instead of 0 */
		parent::__construct(0, $errorMessage, null);
		$this->responseCode = 500;
	}
}
