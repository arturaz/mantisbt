<?php
namespace MantisBT\Exception\Issue\Tag;
use MantisBT\Exception\ExceptionAbstract;

class TagNotAttached extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Tag is not attached to the issue.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
