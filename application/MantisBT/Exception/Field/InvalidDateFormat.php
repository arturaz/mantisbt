<?php
namespace MantisBT\Exception\Field;
use MantisBT\Exception\ExceptionAbstract;

/* TODO: this exception needs some parameters to let the user know what date
 * format was expected. It also needs to consider international date formats.
 */
class InvalidDateFormat extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Invalid date format.');
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
