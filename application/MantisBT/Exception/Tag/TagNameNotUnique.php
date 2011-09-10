<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TagNameNotUnique extends ExceptionAbstract {
	public function __construct($tagName) {
		$errorMessage = lang_get(ERROR_TAG_DUPLICATE, null, false);
		$errorMessage = sprintf($errorMessage, $tagName);
		parent::__construct(ERROR_TAG_DUPLICATE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
