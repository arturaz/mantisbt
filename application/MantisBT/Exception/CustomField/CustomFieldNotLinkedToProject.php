<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

/* TODO: This exception needs to be reviewed. It's not clear what the purpose
 * or usage of this exception is.
 */
class CustomFieldNotLinkedToProject extends ExceptionAbstract {
	public function __construct($fieldName, $fieldID) {
		$errorMessage = lang_get(ERROR_CUSTOM_FIELD_NOT_LINKED_TO_PROJECT, null, false);
		$errorMessage = sprintf($errorMessage, $fieldName, $fieldID);
		parent::__construct(ERROR_CUSTOM_FIELD_NOT_LINKED_TO_PROJECT, $errorMessage, null);
		$this->responseCode = 500;
	}
}
