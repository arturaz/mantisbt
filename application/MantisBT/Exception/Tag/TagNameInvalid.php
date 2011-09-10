<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TagNameInvalid extends ExceptionAbstract {
	public function __construct($tagName) {
		$errorMessage = lang_get(ERROR_TAG_NAME_INVALID, null, false);
		$errorMessage = sprintf($errorMessage, $tagName);
		parent::__construct(ERROR_TAG_NAME_INVALID, $errorMessage, null);
		$this->responseCode = 400;
	}
}
