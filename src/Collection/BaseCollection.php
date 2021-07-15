<?php

namespace Starship\Collection;

/**
 *
 * Create the BaseCollection model.
 * This can be extended for the post_types that need this Collection
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class BaseCollection
{
	/**
	 * Set post_type for this model
	 */
	public const CPT = 'base_model';
	public const OPTION_PAGE = 'base_model';

	/**
	 * Get field of current post
	 *
	 * @param $selector
	 *
	 * @return mixed
	 */
	public function getField($selector)
	{
		return get_field($selector, self::OPTION_PAGE);
	}

	/**
	 * Get fields of current post
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_field(self::OPTION_PAGE);
	}
}
