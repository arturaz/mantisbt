<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class PluginAlreadyInstalled extends ExceptionAbstract {
	public function __construct($pluginName) {
		$errorMessage = lang_get(ERROR_PLUGIN_ALREADY_INSTALLED, null, false);
		$errorMessage = sprintf($errorMessage, $pluginName);
		parent::__construct(ERROR_PLUGIN_ALREADY_INSTALLED, $errorMessage, null);
		$this->responseCode = 400;
	}
}
