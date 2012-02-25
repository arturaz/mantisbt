<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

class LastAdministratorProtected extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('You cannot remove or demote the last administrator account. To perform the action you requested, you first need to create another administrator account.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
