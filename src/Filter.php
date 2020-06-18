<?php

/**
 * EasyGd - a PHP framework for use GD easier
 *
 * @author      Florent Brusciano
 * @copyright   2013 Florent Brusciano
 * @version     1.1.0
 * @package     Easy
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Easygd;

/**
 * Easy
 * @package Easy
 * @author  Florent Brusciano
 * @since   1.0.0
 */
abstract class Filter
{

	const FILTER_PRESET = 1;
	const FILTER_LOOKUPTABLE = 2;
	const FILTER_CONVOLUTION = 3;

	public function create()
	{

		$arg_list = func_get_args();
		$filterType = array_shift($arg_list);

		switch ($filterType) {
			case self::FILTER_LOOKUPTABLE:
				$filterName = $arg_list[0];
				return (new LookUpTable)->create($filterName);
				break;
			case self::FILTER_CONVOLUTION:
				$matrix = $arg_list[0];
				return Convolution::create($matrix);
				break;
			case self::FILTER_PRESET:
				if (count($arg_list) == 1) {
					$presetName = $arg_list[0];
					return Preset::create($presetName);
				} else {
					$presetName = array_shift($arg_list);
					return call_user_func_array(array(__NAMESPACE__ . '\Preset', $presetName), $arg_list);
				}
			default:
				break;
		}
	}

	abstract public function process(Image $image);
}
