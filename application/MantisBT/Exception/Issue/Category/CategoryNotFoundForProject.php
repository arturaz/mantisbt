<?php
namespace MantisBT\Exception\Issue\Category;
use MantisBT\Exception\ExceptionAbstract;

class CategoryNotFoundForProject extends ExceptionAbstract {
	public function __construct($categoryName, $projectName) {
		$errorMessage = sprintf(_('Category "%1$s" not found for project "%2$s".'), $categoryName, $projectName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
