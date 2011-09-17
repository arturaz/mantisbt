<?php
namespace MantisBT\Exception\Filter;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class FilterTooOldToUpgrade extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILTER_TOO_OLD, null, false);
		parent::__construct(ERROR_FILTER_TOO_OLD, $errorMessage, null);
		$this->responseCode = 500;
	}
}
