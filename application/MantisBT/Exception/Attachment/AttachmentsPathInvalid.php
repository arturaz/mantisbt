<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentsPathInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Invalid upload path. Directory either does not exist or not writable to webserver.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
