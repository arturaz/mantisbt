<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SponsorshipAmountTooLow extends ExceptionAbstract {
	public function __construct($proposedAmount, $minimumAmount) {
		$errorMessage = lang_get(ERROR_SPONSORSHIP_AMOUNT_TOO_LOW, null, false);
		$errorMessage = sprintf($errorMessage, $proposedAmount, $minimumAmount);
		parent::__construct(ERROR_SPONSORSHIP_AMOUNT_TOO_LOW, $errorMessage, null);
		$this->responseCode = 400;
	}
}
