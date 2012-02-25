<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentNotReadable extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('File upload failed. File is not readable by MantisBT. Please check the project settings.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
