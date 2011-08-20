<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class IssueDuplicateSelf extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_BUG_DUPLICATE_SELF, null, false);
		parent::__construct(ERROR_BUG_DUPLICATE_SELF, $errorMessage, null);
		$this->responseCode = 400;
	}
}
