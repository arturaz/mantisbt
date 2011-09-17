<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

require_api('lang_api.php');

/* TODO: This class is currently too vague. Plugins should throw more detailed
 * exceptions. Perhaps this class can be abstracted so that it can be extended
 * by plugins, but handled by MantisBT core in consistent ways.
 */
class InstallationFailed extends ExceptionAbstract {
	public function __construct($pluginName, $failureReason) {
		$errorMessage = lang_get(ERROR_PLUGIN_INSTALL_FAILED, null, false);
		$errorMessage = sprintf($errorMessage, $pluginName, $failureReason);
		parent::__construct(ERROR_PLUGIN_INSTALL_FAILED, $errorMessage, null);
		$this->responseCode = 500;
	}
}
