<?php
namespace MantisBT\Exception\Sponsorship;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class SponsorshipDisabled extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_SPONSORSHIP_NOT_ENABLED, null, false);
		parent::__construct(ERROR_SPONSORSHIP_NOT_ENABLED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
