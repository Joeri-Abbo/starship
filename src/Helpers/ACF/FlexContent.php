<?php

namespace Starship\Helpers\ACF;

use Starship\Helpers\BaseHelper;

class FlexContent
{
	private $layouts;

	public function __construct()
	{
	}

	/**
	 * Get the flex content of post
	 *
	 * @param int $post_id
	 * @param string $field
	 *
	 * @return array|false
	 */
	public function getTheFlexContent(int $post_id, string $field)
	{
		$model = starship_get_post($post_id);
		if ( ! $model) {
			$layouts = $model->getField($field);
		} else {
			$layouts = get_field($field, $post_id);
		}

		if ( ! $layouts || ! is_array($layouts)) {
			return false;
		}

		return $this->getFlexContent($layouts);

	}

	/**
	 * Get the flex contents
	 *
	 * @param array $layouts
	 *
	 * @return array
	 */
	private function getFlexContent(array $layouts): array
	{
		$this->getTheLayouts();

		foreach ($layouts as $key => &$layout) {
			$layout = $this->getLayout($layout, $key);
		}

		return $layouts;
	}

	/**
	 * Get the layout
	 *
	 * @param array $layout
	 * @param int $index
	 *
	 * @return mixed
	 */
	private function getLayout(array $layout, int $index)
	{
		if (key_exists($layout['acf_fc_layout'], $this->layouts)) {
			return new $this->layouts[$layout['acf_fc_layout']]($layout, $index);
		} else {
			return new $this->layouts['default']($layout, $index);
		}

	}

	/**
	 * Get the Layouts
	 * @return array|false
	 */
	private function getTheLayouts()
	{
		$layouts = array_diff(scandir(STARSHIP_PATH . 'src/ACF/Layouts'), array('.', '..'));
		if (empty($layouts)) {
			return false;
		}
		$layouts = BaseHelper::unsetValueOfArray('index.php', $layouts);
		$layouts = BaseHelper::stripPartOfArrayValue('.php', $layouts);


		$classes = $this->getClasses('Starship\ACF\Layouts\\', $layouts);

		$this->layouts = apply_filters(STARSHIP_PREFIX . '_classes_acf_layouts', $classes);

		return $this->layouts;
	}

	/**
	 * Generate the classes
	 *
	 * @param string $namespace
	 * @param array $classes
	 *
	 * @return array
	 */
	private function getClasses(string $namespace, array $classes): array
	{
		$items = [];
		foreach ($classes as $class) {
			$c = $namespace . $class;
			if (class_exists($c)) {
				$items[$c::LAYOUT] = $c;
			}
		}

		return $items;
	}
}
