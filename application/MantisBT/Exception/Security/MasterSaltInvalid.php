<?php
namespace MantisBT\Exception\Security;
use MantisBT\Exception\ExceptionAbstract;

class MasterSaltInvalid extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('For security reasons MantisBT will not operate when $g_crypto_master_salt is not specified correctly in config_inc.php.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
