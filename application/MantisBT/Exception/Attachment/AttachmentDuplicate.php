<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('This is a duplicate file. Please delete the existing file first.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
