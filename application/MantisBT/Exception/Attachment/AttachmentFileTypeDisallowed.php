<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentFileTypeDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILE_NOT_ALLOWED, null, false);
		parent::__construct(ERROR_FILE_NOT_ALLOWED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
