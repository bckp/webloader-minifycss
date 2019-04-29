<?php declare(strict_types=1);
/**
 * CSS minify filter
 *
 * This is proprietary code, licensed under Terms of ATLAS consulting license
 * for more information about license please visit www.atlascon.cz
 *
 * @license MIT
 * @author Gary Jones
 * @author Radovan Kepak <radovan@kepak.eu>
 *  --------------------------------------------------------------------------
 */
namespace Bckp\WebLoader\Filter;

/**
 * Class CssMinifyFilter
 *
 * @package Bckp\WebLoader\Filter
 */
class CssMinifyFilter {
	/**
	 * @param string $code
	 * @return string
	 */
	public function filter(string $code): string {
		// Normalize whitespace
		$code = preg_replace('/\s+/', ' ', $code);

		// Remove spaces before and after comment
		$code = preg_replace('/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $code);

		// Remove comment blocks, everything between /* and */, unless
		// preserved with /*! ... */
		$code = preg_replace('/\/\*(?!\!)(.*?)\*\//', '', $code);

		// Remove ; before }
		$code = preg_replace('/;(?=\s*})/', '', $code);

		// Remove space after , : ; { } */ >
		$code = preg_replace('/(,|:|;|\{|}|\*\/|>) /', '$1', $code);

		// Remove space before , ; { } ( ) >
		$code = preg_replace('/ (,|;|\{|}|\(|\)|>)/', '$1', $code);

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$code = preg_replace('/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $code);

		// Strips units if value is 0 (converts 0px to 0)
		$code = preg_replace('/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $code);

		// Converts all zeros value into short-hand
		$code = preg_replace('/0 0 0 0/', '0', $code);

		// Shorten 6-character hex color codes to 3-character where possible
		$code = preg_replace('/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $code);

		// Return trimmed string
		return trim($code);
	}
}
