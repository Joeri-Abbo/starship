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
	 * Get the post_type
	 * @return string
	 */
	public function getType(): string
	{
		return $this::CPT;
	}

	/**
	 * Get the post_type
	 * @return string
	 */
	public function getPostType(): string
	{
		return $this->getType();
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
		return get_field($selector, $this::OPTION_PAGE);
	}

	/**
	 * Get fields of current post
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_field($this::OPTION_PAGE);
	}

	/**
	 * get the archive url
	 * @return mixed
	 */
	public function getUrl(): string
	{
		return get_post_type_archive_link($this::CPT);
	}
}
