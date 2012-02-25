<?php
namespace MantisBT\Exception\TimeZone;
use MantisBT\Exception\ExceptionAbstract;

class TimeZoneUpdateFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Unable to update timezone.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
