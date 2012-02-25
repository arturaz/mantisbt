<?php
namespace MantisBT\Exception\Email;
use MantisBT\Exception\ExceptionAbstract;

class EmailAddressInvalid extends ExceptionAbstract {
	public function __construct($invalidEmailAddress) {
		$errorMessage = sprintf(_('The provided email address (%1$s) is invalid.'), $invalidEmailAddress);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
