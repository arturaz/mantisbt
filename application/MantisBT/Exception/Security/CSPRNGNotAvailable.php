<?php
namespace MantisBT\Exception\Security;
use MantisBT\Exception\ExceptionAbstract;

/* CSPRNG = Cryptographically secure pseudorandom number generator */
class CSPRNGNotAvailable extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Unable to find a source of strong randomness for cryptographic purposes.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
