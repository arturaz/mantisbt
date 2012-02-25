<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

class PluginNotRegistered extends ExceptionAbstract {
	public function __construct($pluginName) {
		$errorMessage = sprintf(_('The "%1$s" plugin is not registered with MantisBT.'), $pluginName);
		parent::__construct($errorMessage);
		$this->responseCode = 404;
	}
}
