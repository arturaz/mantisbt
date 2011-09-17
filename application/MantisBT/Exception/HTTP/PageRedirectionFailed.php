<?php
namespace MantisBT\Exception\HTTP;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class PageRedirectionFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_PAGE_REDIRECTION, null, false);
		parent::__construct(ERROR_PAGE_REDIRECTION, $errorMessage, null);
		$this->responseCode = 500;
	}
}
