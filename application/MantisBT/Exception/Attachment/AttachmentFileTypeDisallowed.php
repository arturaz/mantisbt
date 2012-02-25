<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentFileTypeDisallowed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('File type not allowed for uploads.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
