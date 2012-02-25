<?php
namespace MantisBT\Exception\Filter;
use MantisBT\Exception\ExceptionAbstract;

class FilterTooOldToUpgrade extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('The filter you are trying to use is too old to be upgraded. Please re-create it.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
