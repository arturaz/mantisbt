<?php
namespace MantisBT\Exception\Issue\Comment;
use MantisBT\Exception\ExceptionAbstract;

class CommentNotFound extends ExceptionAbstract {
	public function __construct($commentID) {
		$errorMessage = sprintf(_('Comment %1$d not found.'), $commentID);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
