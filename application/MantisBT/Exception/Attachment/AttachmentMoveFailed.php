<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentMoveFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Uploaded file could not be moved to the file storage directory. Directory either does not exist or not writable to webserver.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
