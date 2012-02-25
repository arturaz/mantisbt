<?php
namespace MantisBT\Exception\Email;
use MantisBT\Exception\ExceptionAbstract;

class DisposableEmailAddressDisallowed extends ExceptionAbstract {
	public function __construct($invalidEmailAddress) {
		$errorMessage = _('The e-mail address "%1$s" has been deemed to be provided by a disposable/temporary e-mail service. These addresses are not permitted. Please specify a permanent e-mail address instead.');
		$errorMessage = sprintf($errorMessage, $invalidEmailAddress);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
