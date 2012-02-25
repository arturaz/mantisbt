<?php
namespace MantisBT\Exception\Issue\Category;
use MantisBT\Exception\ExceptionAbstract;

class CategoryDuplicate extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('A category with that name already exists.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
