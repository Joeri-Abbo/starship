<?php

namespace Starship\Helpers;

class Taxonomy
{
	/**
	 * Init all the given taxonomy models. For hooks and filters for example
	 */
	public function init()
	{
		add_action('after_setup_theme', function () {
			foreach ($this->getTheTaxonomies() as $class) {
				if (class_exists($class)) {
					$class::preInit();
				}
			}
		});
	}

	public function __construct()
	{
		self::init();
		add_action('template_redirect', [$this, 'addTaxonomyObject']);
	}

	/**
	 * Add taxonomy model object to the global var
	 *
	 * @return void
	 */
	public function addTaxonomyObject()
	{
		$GLOBALS[STARSHIP_GLOBAL_TAXONOMY] = $this->getTaxonomy(get_queried_object());
	}

	/**
	 * Get the starship Taxonomy model
	 * @return false|mixed
	 */
	public function getTaxonomy($term = null)
	{
		if ($term === null || $term === '') {
			return $this->getTheTaxonomy();
		} elseif (is_int($term)) {
			return $this->getTaxonomyById($term);
		} elseif ($term instanceof \WP_Term) {
			return $this->getTaxonomyByTaxonomy($term);;
		} else {
			return false;
		}
	}

	/**
	 * Get Taxonomies
	 *
	 * @param $taxonomies array
	 *
	 * @return array
	 */
	public function getTaxonomies(array $taxonomies): array
	{
		foreach ($taxonomies as &$taxonomy) {
			$taxonomy = $this->getTaxonomy($taxonomy);
		}

		return $taxonomies;
	}

	/**
	 * Get the Taxonomy model by global
	 * @return false|mixed
	 */
	public function getTheTaxonomy()
	{
		return $GLOBALS[STARSHIP_GLOBAL_TAXONOMY] ?? false;
	}

	/**
	 * Get the post by id
	 *
	 * @param int $id
	 *
	 * @return false|mixed
	 */
	private function getTaxonomyById(int $id)
	{
		return $this->getTaxonomyByTaxonomy(get_term_by('id', $id));
	}

	/**
	 * Get the taxonomy by WP taxonomy object
	 * @return false|mixed
	 */
	private function getTaxonomyByTaxonomy(\WP_Term $taxonomy)
	{
		if (empty($taxonomy->taxonomy)) {
			return false;
		}

		$classes = $this->getTheTaxonomies();

		foreach ($classes as $class) {
			if ($class::TAXONOMY === $taxonomy->taxonomy) {
				return new $class($taxonomy);
			}
		}

		return false;
	}

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
				$items[$c::TAXONOMY] = $c;
			}
		}

		return $items;
	}

	/**
	 * Get the taxonomies models
	 * @return array|false
	 */
	private function getTheTaxonomies()
	{
		$taxonomies = array_diff(scandir(STARSHIP_PATH . 'src/Taxonomy'), array('.', '..'));
		if (empty($taxonomies)) {
			return false;
		}
		$taxonomies = BaseHelper::unsetValueOfArray('index.php', $taxonomies);
		$taxonomies = BaseHelper::stripPartOfArrayValue('.php', $taxonomies);


		$classes = static::getClasses('Starship\Taxonomy\\', $taxonomies);

		return apply_filters(STARSHIP_PREFIX . '_classes_taxonomies', $classes);
	}
}
