<?php
namespace MantisBT\Exception\Issue\Version;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class VersionNotFound extends ExceptionAbstract {
	public function __construct($versionID) {
		$errorMessage = lang_get(ERROR_VERSION_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $versionID);
		parent::__construct(ERROR_VERSION_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
