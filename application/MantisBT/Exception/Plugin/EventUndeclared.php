<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class EventUndeclared extends ExceptionAbstract {
	public function __construct($eventName) {
		$errorMessage = lang_get(ERROR_EVENT_UNDECLARED, null, false);
		$errorMessage = sprintf($errorMessage, $eventName);
		parent::__construct(ERROR_EVENT_UNDECLARED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
