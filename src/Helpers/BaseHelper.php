<?php


namespace Starship\Helpers;


class BaseHelper
{

	/**
	 * Generate the classes
	 *
	 * @param string $namespace
	 * @param array $classes
	 *
	 * @return array
	 */
	public static function getClasses(string $namespace, array $classes): array
	{
		$items = [];
		foreach ($classes as $class) {
			$c = $namespace . $class;
			if (class_exists($c)) {
				$items[$c::CPT] = $c;
			}
		}

		return $items;
	}

	/**
	 * Unset item by value
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	public static function unsetValueOfArray(string $value, array $items): array
	{
		if (($key = array_search($value, $items)) !== false) {
			unset($items[$key]);
		}

		return $items;
	}

	/**
	 * Strip part of value in array
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	public static function stripPartOfArrayValue(string $value, array $items): array
	{
		foreach ($items as &$item) {
			$item = str_replace($value, '', $item);

		}

		return array_values($items);

	}

}
