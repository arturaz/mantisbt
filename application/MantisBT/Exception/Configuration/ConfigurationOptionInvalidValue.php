<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

class ConfigurationOptionInvalidValue extends ExceptionAbstract {
	public function __construct($configurationOptionName, $configurationOptionValue) {
		$errorMessage = sprintf(_('Configuration option "%1$s" has invalid value "%2$s".', $configurationOptionName, $configurationOptionValue));
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
