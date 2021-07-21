<?php

namespace Starship\Taxonomy;

/**
 *
 * Create the BaseCategory model.
 * This can be extended for the taxonomies that need this Model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class BaseCategory
{
	/**
	 * Set post_type for this model
	 */
	public const CPT = 'base_model';
	public const TAXONOMY = 'base_category';
	/**
	 * @var \WP_Term
	 */
	private $term;

	/**
	 * Product constructor.
	 *
	 * @param \WP_Term $term Post
	 */
	public function __construct(\WP_Term $term)
	{
		$this->term = $term;
	}

	/**
	 * Get term
	 * @return \WP_Term
	 */
	public function getTerm(): \WP_Term
	{
		return $this->term;
	}

	/**
	 * Init for hooks/filters functions
	 */
	public static function preInit()
	{
		if (static::registerTaxonomy()) {
			static::registerTheTaxonomy();
		}
		static::init();
	}

	/**
	 * Init for hooks/filters functions
	 */
	public static function init()
	{

	}

	/**
	 * Register taxonomy
	 * @return bool
	 */
	public static function registerTaxonomy(): bool
	{
		return false;
	}

	/**
	 * Set hierarchical var
	 * @return bool
	 */
	public static function taxonomyHierarchical(): bool
	{
		return false;
	}

	/**
	 * Set show ui var
	 * @return bool
	 */
	public static function taxonomyShowUi(): bool
	{
		return true;
	}

	/**
	 * Set admin column var
	 * @return bool
	 */
	public static function taxonomyShowAdminColumn(): bool
	{
		return true;
	}

	/**
	 * Set query var var
	 * @return bool
	 */
	public static function taxonomyQueryVar(): bool
	{
		return true;
	}

	/**
	 * Set singular name for post_type
	 * @return string
	 */
	public static function taxonomySingularName(): string
	{
		return static::CPT;
	}

	/**
	 * Set name for post_type
	 * @return string
	 */
	public static function taxonomyName(): string
	{
		return static::CPT;
	}

	/**
	 * Register taxonomy
	 */
	public static function registerTheTaxonomy()
	{
		$options = [
			'hierarchical'      => static::taxonomyHierarchical(),
			'show_ui'           => static::taxonomyShowUi(),
			'show_admin_column' => static::taxonomyShowAdminColumn(),
			'query_var'         => static::taxonomyQueryVar(),
			'rewrite'           => ['slug' => static::taxonomyRewriteSlug()]
		];

		$labels = [
			'name'          => __(static::taxonomyName(), 'ecs-admin'),
			'singular_name' => __(static::taxonomySingularName(), 'ecs-admin'),
			'edit_item'     => sprintf(__('Bewerk %s', 'ecs-admin'), static::taxonomySingularName()),
			'update_item'   => sprintf(__('%s bijwerken', 'ecs-admin'), static::taxonomySingularName()),
			'add_new_item'  => sprintf(__('Nieuw %s toevoegen', 'ecs-admin'), static::taxonomySingularName()),
			'menu_name'     => sprintf(__('%s', 'ecs-admin'), static::taxonomySingularName()),
		];

		$options = apply_filters(STARSHIP_PREFIX . '_taxonomy_' . static::TAXONOMY . '_options', $options);
		$labels  = apply_filters(STARSHIP_PREFIX . '_taxonomy_' . static::TAXONOMY . '_labels', $labels);

		$options['labels'] = $labels;

		register_taxonomy(
			static::TAXONOMY,
			[static::CPT],
			$options
		);
	}

	/**
	 * Set rewrite slug for taxonomy
	 * @return string
	 */
	public static function taxonomyRewriteSlug(): string
	{
		return static::TAXONOMY;
	}

	/**
	 * Get field of current taxonomy
	 *
	 * @param $selector
	 *
	 * @return mixed
	 */
	public function getField($selector)
	{
		return get_field($selector, $this->getTerm());
	}

	/**
	 * Get fields of current taxonomy
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_fields($this->getTerm());
	}
}
