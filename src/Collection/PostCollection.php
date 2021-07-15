<?php

namespace Starship\Collection;

/**
 *
 * Create the PostCollection model.
 * This can be extended for the post_types that need this Collection
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class PostCollection extends BaseCollection
{
	/**
	 * Set post_type for this model
	 */
	public const CPT = 'base_model';
	public const OPTION_PAGE = 'base_model';


}
