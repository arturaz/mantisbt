<?php
namespace MantisBT\Exception\Language;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LanguageStringNotFound extends ExceptionAbstract {
	public function __construct($languageStringID) {
		$errorMessage = lang_get(ERROR_LANG_STRING_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $languageStringID);
		parent::__construct(ERROR_LANG_STRING_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
