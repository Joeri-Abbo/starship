<?php

namespace Name\space\Path\Here\Models;

use Starship\Models\BaseModel;

/**
 *
 * Add new post_type with model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class Article extends BaseModel
{
	public const CPT = 'article';

	/** @inheritDoc */
	public static function registerPostType(): bool
	{
		return true;
	}

	/** @inheritDoc */
	public static function postTypeMenuIcon(): string
	{
		return 'dashicons-format-aside';
	}

	/** @inheritDoc */
	public static function postTypeRewriteSlug(): string
	{
		return 'nieuws';
	}

	/** @inheritDoc */
	public static function postTypeName(): string
	{
		return 'Nieuwsberichten';
	}

	/** @inheritDoc */
	public static function postTypeSingularName(): string
	{
		return 'Nieuwsbericht';
	}
}
