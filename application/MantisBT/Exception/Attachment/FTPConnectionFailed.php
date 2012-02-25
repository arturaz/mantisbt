<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

class FTPConnectionFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Unable to connect to FTP server.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
