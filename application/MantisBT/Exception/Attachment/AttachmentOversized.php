<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class AttachmentOversized extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('File upload failed. This is likely because the filesize was larger than is currently allowed by this PHP installation.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
