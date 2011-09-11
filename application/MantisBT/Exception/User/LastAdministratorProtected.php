<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class LastAdministratorProtected extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_USER_CHANGE_LAST_ADMIN, null, false);
		parent::__construct(ERROR_USER_CHANGE_LAST_ADMIN, $errorMessage, null);
		$this->responseCode = 400;
	}
}
