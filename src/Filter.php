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
	const FILTER_AFFINE = 4;

	public static function factory($filtered)
	{
		switch ($filtered->getType()) {
			case self::FILTER_LOOKUPTABLE:
				return (new LookupTableFilter())->create($filtered);
				break;
			case self::FILTER_CONVOLUTION:
				return (new ConvolutionFilter())->create($filtered);
				break;
			case self::FILTER_PRESET:
				return (new PresetFilter())->create($filtered);
			case self::FILTER_AFFINE:
				return (new AffineFilter())->create($filtered);
			default:
				break;
		}
	}

	abstract public function create($filtered);
	abstract public function process(Image $image);

	public static function __callStatic($name, $arguments)
	{
		$filtered = null;
		if (method_exists(PresetFunctions::class, $name)) {
			$filtered = call_user_func_array([PresetFunctions::class, $name], $arguments);
		} elseif (method_exists(ConvolutionFunctions::class, $name)) {
			$filtered = call_user_func_array([ConvolutionFunctions::class, $name], $arguments);
		} elseif (method_exists(LookupTableFunctions::class, $name)) {
			$closure = \Closure::fromCallable([new LookupTableFunctions(), $name]);
			$filtered = (new LookUpTable())->create($closure);
		}
		if (method_exists(AffineFunctions::class, $name)) {
			$filtered = call_user_func_array([AffineFunctions::class, $name], $arguments);
		}

		return static::factory($filtered);
	}
}
