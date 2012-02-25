<?php
namespace MantisBT\Exception\Language;
use MantisBT\Exception\ExceptionAbstract;

class LanguageStringNotFound extends ExceptionAbstract {
	public function __construct($languageStringID) {
		$errorMessage = sprintf(_('String %1$d not found.'), $languageStringID);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
