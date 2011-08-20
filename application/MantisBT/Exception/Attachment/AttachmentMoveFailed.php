<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentMoveFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILE_MOVE_FAILED, null, false);
		parent::__construct(ERROR_FILE_MOVE_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
