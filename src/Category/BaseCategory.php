<?php

namespace Starship\Category;

/**
 *
 * Create the BaseCategory model.
 * This can be extended for the post_types that need this Collection
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
	public function __construct($term)
	{
		$this->term = $term;
	}

	/**
	 * Get ter
	 * @return \WP_Term
	 */
	public function getTerm(): \WP_Term
	{
		return $this->term;
	}

	/**
	 * Get field of current post
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
	 * Get fields of current post
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_field($this->getTerm());
	}
}
