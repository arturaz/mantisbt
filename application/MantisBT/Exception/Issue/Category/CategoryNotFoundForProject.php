<?php
namespace MantisBT\Exception\Issue\Category;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class CategoryNotFoundForProject extends ExceptionAbstract {
	public function __construct($categoryName, $projectName) {
		$errorMessage = lang_get(ERROR_CATEGORY_NOT_FOUND_FOR_PROJECT, null, false);
		$errorMessage = sprintf($errorMessage, $categoryName, $projectName);
		parent::__construct(ERROR_CATEGORY_NOT_FOUND_FOR_PROJECT, $errorMessage, null);
		$this->responseCode = 400;
	}
}
