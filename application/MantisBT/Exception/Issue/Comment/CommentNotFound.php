<?php
namespace MantisBT\Exception\Issue\Comment;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class CommentNotFound extends ExceptionAbstract {
	public function __construct($commentID) {
		$errorMessage = lang_get(ERROR_BUGNOTE_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $commentID);
		parent::__construct(ERROR_BUGNOTE_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 400;
	}
}
