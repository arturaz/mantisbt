<?php
namespace MantisBT\Exception;
use \Exception;

abstract class ExceptionAbstract extends Exception {
	protected $message = 'Unknown exception';
	protected $responseCode = 500;

	public function __construct($message) {
		parent::__construct($message);
	}

	public function __toString() {
		return get_class($this);
	}
}
