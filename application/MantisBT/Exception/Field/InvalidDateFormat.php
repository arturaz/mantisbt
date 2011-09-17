<?php
namespace MantisBT\Exception\Field;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

/* TODO: this exception needs some parameters to let the user know what date
 * format was expected. It also needs to consider international date formats.
 */
class InvalidDateFormat extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = lang_get(ERROR_INVALID_DATE_FORMAT, null, false);
		parent::__construct(ERROR_INVALID_DATE_FORMAT, $errorMessage, null);
		$this->responseCode = 400;
	}
}
