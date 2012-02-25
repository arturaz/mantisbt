<?php
namespace MantisBT\Exception\Issue\Tag;
use MantisBT\Exception\ExceptionAbstract;

class TagAlreadyAttached extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Tag is already attached to the issue.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
