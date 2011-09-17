<?php
namespace MantisBT\Exception\Filter;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class FilterNotFound extends ExceptionAbstract {
	public function __construct($filterID) {
		$errorMessage = lang_get(ERROR_FILTER_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $filterID);
		parent::__construct(ERROR_FILTER_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 404;
	}
}
