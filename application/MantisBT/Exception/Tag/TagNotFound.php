<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

class TagNotFound extends ExceptionAbstract {
	public function __construct($tagID) {
		$errorMessage = sprintf(_('Tag %1$d not found.'), $tagID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
