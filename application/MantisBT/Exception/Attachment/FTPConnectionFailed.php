<?php
namespace MantisBT\Exception\Attachment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class FTPConnectionFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_FTP_CONNECT_ERROR, null, false);
		parent::__construct(ERROR_FTP_CONNECT_ERROR, $errorMessage, null);
		$this->responseCode = 500;
	}
}
