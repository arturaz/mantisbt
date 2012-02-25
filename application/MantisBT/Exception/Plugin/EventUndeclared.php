<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

class EventUndeclared extends ExceptionAbstract {
	public function __construct($eventName) {
		$errorMessage = sprintf(_('Event "%1$s" has not yet been declared.'), $eventName);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
