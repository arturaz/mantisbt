<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserProfileNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('User profile not found.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
