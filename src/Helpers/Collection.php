<?php

namespace Starship\Helpers;

class Collection
{
	public function init()
	{
	}

	public function __construct()
	{
		self::init();

		add_action('template_redirect', [$this, 'addCollectionObject']);


	}

	public function addCollectionObject()
	{
		$post_type = get_query_var('post_type');

		if (is_home() && ! is_front_page()) {
			$post_type = 'post';
		}

		if ( ! $post_type) {
			return false;
		}

		$GLOBALS[STARSHIP_GLOBAL_COLLECITON] = $this->getCollection($post_type);
	}

	public function getCollection($post_type = null)
	{
		if ($post_type === null) {
			return $this->getTheCollection();
		} elseif ($post_type) {
			return $this->getCollectionByPostType($post_type);
		} else {
			return false;
		}
	}

	private function getCollectionByPostType(string $post_type)
	{
		if (empty($post_type)) {
			return false;
		}

		$classes = apply_filters(STARSHIP_PREFIX . '_classes_collections', $this->getTheCollections());

		foreach ($classes as $class) {
			if ($class::CPT === $post_type) {
				return new $class();
			}
		}

		return false;
	}


	/**
	 * Get the collections
	 * @return array|false
	 */
	private function getTheCollections()
	{
		$collections = array_diff(scandir(STARSHIP_PATH . 'src/Collection'), array('.', '..'));
		if (empty($collections)) {
			return false;
		}
		$collections = BaseHelper::unsetValueOfArray('index.php', $collections);
		$collections = BaseHelper::stripPartOfArrayValue('.php', $collections);

		return BaseHelper::getClasses('Starship\Collection\\', $collections);
	}


	/**
	 * Get the post model by global
	 * @return false|mixed
	 */
	public function getTheCollection()
	{
		return $GLOBALS[STARSHIP_GLOBAL_COLLECITON] ?? false;
	}
}
