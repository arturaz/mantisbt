<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ConfigurationOptionInvalidValue extends ExceptionAbstract {
	public function __construct($configurationOptionName, $configurationOptionValue) {
		$errorMessage = lang_get(ERROR_CONFIG_OPT_INVALID, null, false);
		$errorMessage = sprintf($errorMessage, $configurationOptionName, $configurationOptionValue);
		parent::__construct(ERROR_CONFIG_OPT_INVALID, $errorMessage, null);
		$this->responseCode = 400;
	}
}
