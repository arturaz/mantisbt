<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class EmptyAttachment extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('No file was uploaded. Please go back and Choose a file before pressing Upload.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
