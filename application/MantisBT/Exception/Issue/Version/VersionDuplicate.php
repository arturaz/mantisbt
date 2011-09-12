<?php
namespace MantisBT\Exception\Issue\Version;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class VersionDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_VERSION_DUPLICATE, null, false);
		parent::__construct(ERROR_VERSION_DUPLICATE, $errorMessage, null);
		$this->responseCode = 400;
	}
}
