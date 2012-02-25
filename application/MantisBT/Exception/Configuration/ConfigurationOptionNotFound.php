<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

class ConfigurationOptionNotFound extends ExceptionAbstract {
	public function __construct($configurationOptionName) {
		$errorMessage = sprintf(_('Configuration option "%1$s" not found.'), $configurationOptionName);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
