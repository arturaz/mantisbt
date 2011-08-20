<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class ConfigurationOptionNotFound extends ExceptionAbstract {
	public function __construct($configurationOptionName) {
		$errorMessage = lang_get(ERROR_CONFIG_OPT_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $configurationOptionName);
		parent::__construct(ERROR_CONFIG_OPT_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 500;
	}
}
