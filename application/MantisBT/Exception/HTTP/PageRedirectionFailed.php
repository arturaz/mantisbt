<?php
namespace MantisBT\Exception\HTTP;
use MantisBT\Exception\ExceptionAbstract;

class PageRedirectionFailed extends ExceptionAbstract {
	public function __construct() {
		$errorMessage = _('Page redirection failed. Ensure that no spaces exist outside the PHP block <?php ... ?> in config_inc.php or custom_*.php files.');
		parent::__construct($errorMessage);
		$this->responseCode = 500;
	}
}
