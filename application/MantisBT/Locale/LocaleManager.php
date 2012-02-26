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
use \Locale;
use MantisBT\Exception\Locale\LocaleNotProvidedByUserAgent;
use MantisBT\Exception\Locale\LocalesNotSupported;

class LocaleManager {
	private $textDomains = array();

	public function __construct() {
		/* Load some additional gettext-style functions (and aliases)
		 * that are missing from PHP's implementation. These functions
		 * are globally accessible.
		 */
		if (!function_exists('pgettext')) {
			require_once('locale_support_functions.php');
		}
	}

	/* $newLocales is either a string (en_US.UTF-8) or an array of strings
	 * that are locale names to try. The order of the strings in the array
	 * is important as the first valid locale name in the array will be
	 * used.
	 */
	public function setLocale($newLocales = null) {
		if ($newLocales === null) {
			if (!$_SERVER['HTTP_ACCEPT_LANGUAGE'])
				throw new LocaleNotProvidedByUser();
			$newLocales = Locale::acceptFromHttp($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		}
		$result = setlocale(LC_ALL, $newLocales);
		if ($result === false) {
			if (!is_array($newLocales))
				$newLocales = array($newLocales);
			throw new LocalesNotSupported($newLocales);
		}
		return $result;
	}

	public function addTextDomain($textDomainName, $path) {
		$this->textDomains[$textDomainName] = $path;
		bindtextdomain($textDomainName, $path);
		bind_textdomain_codeset($textDomainName, 'UTF-8');
	}

	/* Reads the Accept-Language header sent by the browser in the format
	 * specified in section 14.4 of RFC2616 and returns an array of
	 * RFC1766 formatted language tags and quality values (preferences),
	 * sorted from the most preferred language to the least preferred.
	 *
	 * If this header was not sent, contained no language preferences or
	 * only had a catch-all "*", this function will return an empty array.
	 *
	 * Based on Jesse Skinner's example at
	 * http://www.thefutureoftheweb.com/blog/use-accept-language-header
	 *
	 * @TODO: Cater for the "*" catch-all so we know with certainty whether
	 *        the browser can accept any language as a fall back.
	 */
	public function getParsedAcceptLanguageHeader() {
		$languageTags = array();

		/* Ensure that the browser has sent an Accept-Language header */
		if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			return $languageTags;
		}

		/* Split the Accept-Language header into components */
		$languageTagParts = array();
		preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $languageTagParts);

		/* Create an array of accepted language tags */
		$languageTags = array_combine($languageTagParts[1], $languageTagParts[4]);
		foreach ($languageTags as $languageRange => $qualityValue) {
			/* If a quality value wasn't provided by the browser,
			 * use the default value of 1.0 */
			$qualityValue = $qualityValue === '' ? 1.0 : (float)$qualityValue;
			$languageTags[$languageRange] = $qualityValue;
		}

		/* Sort the array of language tags by quality value such that
		 * the most preferred language is the first element of the
		 * array. */
		arsort($languageTags, SORT_NUMERIC);

		return $languageTags;
	}

/* DEPRECATED CODE NO LONGER REQUIRED
			$languageTagsAccepted = $this->getParsedAcceptLanguageHeader();
			$newLocales = array();
			foreach ($languageTagsAccepted as $languageRange => $qualityValue) {
				$languageTagParts = array();
				preg_match('/([a-z]{1,8})(-([a-z]{1,8}))?/i', $languageRange, $languageTagParts);
				$newLocale = strtolower($languageTagParts[1]);
				if (count($languageTagParts) === 4)
					$newLocale .= '_' . strtoupper($languageTagParts[3]);
				$newLocales[] = $newLocale . '.UTF-8';
			}
*/
}
