<?php
namespace MantisBT\Exception\User;
use MantisBT\Exception\ExceptionAbstract;

/* TODO: remove this exception entirely. It is non-sensical and short-sighted
 * to think that real names are unique. There are plenty of people in larger
 * organisations or open source projects with the same real name.
 */
class UserRealNameMatchesExistingUserName extends ExceptionAbstract {
	public function __construct($userRealName) {
		$errorMessage = sprintf(_('An account already exists with a "real name" of "%1$s". Only one account is permitted per person.'), $userRealName);
		parent::__construct($errorMessage);
		$this->responseCode = 400;
	}
}
