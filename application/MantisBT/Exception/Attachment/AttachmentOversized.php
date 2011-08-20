<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class AttachmentOversized extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FILE_TOO_BIG, null, false);
		parent::__construct( ERROR_FILE_TOO_BIG, $errorMessage, null );
		$this->responseCode = 400;
	}
}
