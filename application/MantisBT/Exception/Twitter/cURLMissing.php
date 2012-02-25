<?php
namespace MantisBT\Exception\Twitter;
use MantisBT\Exception\ExceptionAbstract;

class cURLMissing extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Twitter integration requires the PHP cURL extension be installed and loaded.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
