<?php
namespace MantisBT\Exception\CustomField;
use MantisBT\Exception\ExceptionAbstract;

/* TODO: This exception needs to be reviewed. It's not clear what the purpose
 * or usage of this exception is.
 */
class CustomFieldNotLinkedToProject extends ExceptionAbstract {
	public function __construct($fieldName, $fieldID) {
		$errorMessage = sprintf(_('Custom field "%1$s" (ID %2$d) not linked to currently active project.'), $fieldName, $fieldID);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
