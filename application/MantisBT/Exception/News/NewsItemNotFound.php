<?php
namespace MantisBT\Exception\News;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class NewsItemNotFound extends ExceptionAbstract {
	public function __construct($newsItemID) {
		$errorMessage = lang_get(ERROR_NEWS_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $newsItemID);
		parent::__construct(ERROR_NEWS_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 404;
	}
}
