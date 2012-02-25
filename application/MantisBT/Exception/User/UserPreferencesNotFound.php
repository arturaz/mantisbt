<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class UserPreferencesNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Preferences could not be found for this user.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
