<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

class PluginPageNotFound extends ExceptionAbstract {
	public function __construct($pluginName, $pageName) {
		$errorMessage = sprintf(_('The "%1$s" plugin could not find the requested page "%2$s".'), $pluginName, $pageName);
		parent::__construct($errorMessage);
		$this->responseCode = 404;
	}
}
