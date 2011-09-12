<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SponsorshipNotFound extends ExceptionAbstract {
	public function __construct($sponsorshipID) {
		$errorMessage = lang_get(ERROR_SPONSORSHIP_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $sponsorshipID);
		parent::__construct(ERROR_SPONSORSHIP_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
