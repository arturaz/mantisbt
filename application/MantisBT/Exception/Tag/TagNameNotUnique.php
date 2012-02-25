<?php
namespace MantisBT\Exception\Tag;
use MantisBT\Exception\ExceptionAbstract;

class TagNameNotUnique extends ExceptionAbstract {
	public function __construct($tagName) {
		$errorMessage = sprintf(_('A tag named "%1$s" already exists. Please choose another name or modify the existing tag.'), $tagName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
