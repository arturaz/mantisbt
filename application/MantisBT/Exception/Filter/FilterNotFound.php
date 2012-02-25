<?php
namespace MantisBT\Exception\Filter;
use MantisBT\Exception\ExceptionAbstract;

class FilterNotFound extends ExceptionAbstract {
	public function __construct($filterID) {
		$errorMessage = sprintf(_('A filter with identifier "%1$d" was not found.'), $filterID);
		parent::__construct($errorMessage);
		$this->responseCode = 404;
	}
}
