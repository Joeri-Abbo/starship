<?php

namespace Name\space\Path\Here\ACF\Layouts;

use Starship\ACF\Layouts\BaseLayout;

/**
 *
 * Create the base layout model.
 * This can be extended for the post_types that need this model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class TitleTextLayout extends BaseLayout
{
	/**
	 * Set post_type for this model
	 */
	public const LAYOUT = 'title_text';
}
