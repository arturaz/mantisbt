<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ConfigurationOptionCannotBeSpecifiedInDatabase extends ExceptionAbstract {
	public function __construct($configurationOptionName) {
		$errorMessage = lang_get(ERROR_CONFIG_OPT_CANT_BE_SET_IN_DB, null, false);
		$errorMessage = sprintf($errorMessage, $configurationOptionName);
		parent::__construct(ERROR_CONFIG_OPT_CANT_BE_SET_IN_DB, $errorMessage, null);
		$this->responseCode = 400;
	}
}
