<?php
namespace MantisBT\Exception\Issue\Category;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class CategoryNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_CATEGORY_NOT_FOUND, null, false);
		parent::__construct(ERROR_CATEGORY_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
