<?php
namespace MantisBT\Exception\Issue\Revision;
use MantisBT\Exception\ExceptionAbstract;

class RevisionNotFound extends ExceptionAbstract {
	public function __construct($revisionID) {
		$errorMessage = sprintf(_('Issue revision %1$d not found.', $revisionID));
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
