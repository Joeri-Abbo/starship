<?php

namespace Starship\Taxonomy;

/**
 *
 * Create the Category model.
 * This can be extended for the post_types that need this Collection
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class Category extends BaseCategory
{
	/**
	 * Set post_type for this model
	 */
	public const CPT = 'post';
	public const TAXONOMY = 'category';

}
