<?php

namespace Starship\Models;

/**
 *
 * Create the base Page model. This can be extended for the post_types that need this model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class Page extends BaseModel
{
	public const CPT = 'page';

	public static function init() {
		self::addAction('wp_head', function (){
			var_dump('test');
		});
	}

}
