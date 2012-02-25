<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

namespace MantisBT\Locale;

# The next 4 functions are courtesy of https://developer.mozilla.org/en/gettext
function pgettext($context, $msgid) {
	$contextString = "{$context}\004{$msgid}";
	$translation = _($contextString);
	if ($translation === $contextString)
		return $msgid;
	else
		return $translation;
}

function npgettext($context, $msgid, $msgid_plural, $num) {
	$contextString = "{$context}\004{$msgid}";
	$contextStringp = "{$context}\004{$msgid_plural}";
	$translation = ngettext($contextString, $contextStringp, $num);
	if ($translation === $contextString || $translation === $contextStringp)
		return $msgid;
	else
		return $translation;
}

function ___($message, $context = "") {
	if ($context !== '')
		return pgettext($context, $message);
	else
		return _($message);
}

function n___($message, $message_plural, $num, $context = "") {
	if ($context !== "")
		return npgettext($context, $message, $message_plural, $num);
	else
		return ngettext($message, $message_plural, $num);
}
