<?php
namespace MantisBT\Exception\Access;
use MantisBT\Exception\ExceptionAbstract;

class SponsorshipAssignerAccessDenied extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Access Denied: Assigning sponsored issues requires a higher access level.');
		parent::__construct($errorMessage);
		$this->responseCode = 403;
	}
}
