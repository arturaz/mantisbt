<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

class TagNameInvalid extends ExceptionAbstract {
	public function __construct($tagName) {
		$errorMessage = sprintf(_('The provided tag name "%1$s" is invalid.'), $tagName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
