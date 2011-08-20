<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentsPathInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_INVALID_UPLOAD_PATH, null, false);
		parent::__construct(ERROR_INVALID_UPLOAD_PATH, $errorMessage, null);
		$this->responseCode = 500;
	}
}
