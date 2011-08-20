<?php
namespace MantisBT\Exception\TimeZone;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TimeZoneUpdateFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_UPDATING_TIMEZONE, null, false);
		parent::__construct(ERROR_UPDATING_TIMEZONE, $errorMessage, null);
		$this->responseCode = 500;
	}
}
