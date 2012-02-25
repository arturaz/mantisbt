<?php
namespace MantisBT\Exception\Locale;
use MantisBT\Exception\ExceptionAbstract;

class LocalesNotSupported extends ExceptionAbstract {
	public function __construct(array $locales) {
		$localesAsString = implode(', ', $locales);
		$errorMessage = sprintf(_('Could not set the current locale to any of the preferences provided: %1$s.'), $localesAsString);
		parent::__construct($errorMessage);
		/* TODO: check response code is the correct one to send */
		$this->responseCode = 500;
	}
}
