<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class PluginNotRegistered extends ExceptionAbstract {
	public function __construct($pluginName) {
		$errorMessage = lang_get(ERROR_PLUGIN_NOT_REGISTERED, null, false);
		$errorMessage = sprintf($errorMessage, $pluginName);
		parent::__construct(ERROR_PLUGIN_NOT_REGISTERED, $errorMessage, null);
		$this->responseCode = 404;
	}
}
