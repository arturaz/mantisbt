<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

class SponsorshipAmountTooLow extends ExceptionAbstract {
	public function __construct($proposedAmount, $minimumAmount) {
		$errorMessage = sprintf(_('Sponsorship (%1$d) is below minimum amount (%2$d).'), $proposedAmount, $minimumAmount);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
