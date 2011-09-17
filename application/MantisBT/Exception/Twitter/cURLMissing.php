<?php
namespace MantisBT\Exception\Twitter;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class cURLMissing extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_TWITTER_NO_CURL_EXT, null, false);
		parent::__construct(ERROR_TWITTER_NO_CURL_EXT, $errorMessage, null);
		$this->responseCode = 500;
	}
}
