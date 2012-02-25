<?php
namespace MantisBT\Exception\Issue\Version;
use MantisBT\Exception\ExceptionAbstract;

class VersionNotFound extends ExceptionAbstract {
	public function __construct($versionID) {
		$errorMessage = sprintf(_('Version %1$d not found.'), $versionID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
