<?php
namespace MantisBT\Exception\News;
use MantisBT\Exception\ExceptionAbstract;

class NewsItemNotFound extends ExceptionAbstract {
	public function __construct($newsItemID) {
		$errorMessage = sprintf(_('News item %1$d not found.'), $newsItemID);
		parent::__construct($errorMessage);
		$this->responseCode = 404;
	}
}
