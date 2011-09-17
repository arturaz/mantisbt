<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

class PluginPageNotFound extends ExceptionAbstract {
	public function __construct($pluginName, $pageName) {
		$errorMessage = lang_get(ERROR_PLUGIN_PAGE_NOT_FOUND, null, false);
		$errorMessage = sprintf($errorMessage, $pluginName, $pageName);
		parent::__construct(ERROR_PLUGIN_PAGE_NOT_FOUND, $errorMessage, null);
		$this->responseCode = 404;
	}
}
