<?php
namespace MantisBT\Exception\Configuration;
use MantisBT\Exception\ExceptionAbstract;

class ConfigurationOptionCannotBeSpecifiedInDatabase extends ExceptionAbstract {
	public function __construct($configurationOptionName) {
		$errorMessage = sprintf(_('Configuration option "%1$s" can not be set in the database. It must be set in config_inc.php.'), $configurationOptionName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
