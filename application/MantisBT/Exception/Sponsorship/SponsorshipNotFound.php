<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

class SponsorshipNotFound extends ExceptionAbstract {
	public function __construct($sponsorshipID) {
		sprintf(_('Sponsorship %1$d not found.'), $sponsorshipID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
