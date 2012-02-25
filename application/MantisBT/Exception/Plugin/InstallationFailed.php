<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

/* TODO: This class is currently too vague. Plugins should throw more detailed
 * exceptions. Perhaps this class can be abstracted so that it can be extended
 * by plugins, but handled by MantisBT core in consistent ways.
 */
class InstallationFailed extends ExceptionAbstract {
	public function __construct($pluginName, $failureReason) {
		$errorMessage = sprintf(_('Installation of the "%1$s" plugin failed. The following reason was provided by the plugin: %2$s.'), $pluginName, $failureReason);
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
