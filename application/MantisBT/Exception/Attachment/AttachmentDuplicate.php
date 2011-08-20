<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILE_DUPLICATE, null, false);
		parent::__construct(ERROR_FILE_DUPLICATE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
