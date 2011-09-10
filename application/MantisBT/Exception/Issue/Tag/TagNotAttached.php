<?php
namespace MantisBT\Exception\Issue\Tag;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class TagNotAttached extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_TAG_NOT_ATTACHED, null, false);
		parent::__construct(ERROR_TAG_NOT_ATTACHED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
