<?php
namespace MantisBT\Exception\Issue\Version;
use MantisBT\Exception\ExceptionAbstract;

class VersionDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('A version with that name already exists.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
