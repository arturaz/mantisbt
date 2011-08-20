<?php
namespace MantisBT\Exception\Issue\Revision;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class RevisionNotFound extends ExceptionAbstract {
	public function __construct($revisionID) {
		$errorMessage = lang_get(ERROR_BUG_REVISION_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $revisionID);
		parent::__construct(ERROR_BUG_REVISION_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
