<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentNotReadable extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_UPLOAD_FAILURE, null, false);
		parent::__construct(ERROR_UPLOAD_FAILURE, $errorMessage, null);
		$this->responseCode = 500;
	}
}
