<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

class SponsorshipDisabled extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Sponsorship support not enabled.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
