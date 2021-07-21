<?php

namespace Name\space\Path\Here\Taxonomies;

use Starship\Taxonomy\BaseCategory;

/**
 *
 * Create the ArticleType taxonomy model.
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class ArticleType extends BaseCategory
{
	public const CPT = 'article';
	public const TAXONOMY = 'article_type';

	/** @inheritDoc */
	public static function registerTaxonomy(): bool
	{
		return true;
	}
}
