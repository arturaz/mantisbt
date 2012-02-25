<?php
namespace MantisBT\Exception\Plugin;
use MantisBT\Exception\ExceptionAbstract;

class PluginAlreadyInstalled extends ExceptionAbstract {
	public function __construct($pluginName) {
		$errorMessage = sprintf(_('The "%1$s" plugin is already installed.'), $pluginName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
