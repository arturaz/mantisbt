<?php
namespace MantisBT\Exception\Issue\Category;
use MantisBT\Exception\ExceptionAbstract;

class CategoryNotFound extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Category not found.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
