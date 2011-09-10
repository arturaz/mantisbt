<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TagNotFound extends ExceptionAbstract {
	public function __construct($tagID) {
		$errorMessage = lang_get(ERROR_TAG_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $tagID);
		parent::__construct(ERROR_TAG_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
