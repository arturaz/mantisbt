<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class EmptyAttachment extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILE_NO_UPLOAD_FAILURE, null, false);
		parent::__construct(ERROR_FILE_NO_UPLOAD_FAILURE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
