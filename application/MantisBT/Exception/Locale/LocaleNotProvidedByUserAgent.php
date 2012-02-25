<?php
namespace MantisBT\Exception\Locale;
use MantisBT\Exception\ExceptionAbstract;

class LocaleNotProvidedByUserAgent extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('An Accept-Language header was expected from your browser, but none was received.');
		parent::__construct($errorMessage);
		/* TODO: check response code is the correct one to send */
		$this->responseCode = 500;
	}
}
