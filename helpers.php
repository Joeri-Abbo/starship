<?php
/*
 * Helper functions for spaceship
 */

/**
 * Get the starship model
 * @return false|mixed
 */
function starship_get_post($post = null)
{
	$model = new Starship\Helpers\Model;

	return $model->getPost($post);
}

/**
 * Get posts models
 *
 * @param array $posts
 *
 * @return mixed
 */
function starship_get_posts(array $posts)
{
	$model = new Starship\Helpers\Model;

	return $model->getPosts($posts);
}

/**
 * Get the starship taxonomy
 * @return false|mixed
 */
function starship_get_term($term = null)
{
	$taxonomy = new Starship\Helpers\Taxonomy;

	return $taxonomy->getTaxonomy($term);
}

/**
 * Get taxonomies models
 *
 * @param array $terms
 *
 * @return mixed
 */
function starship_get_terms(array $terms)
{
	$taxonomy = new Starship\Helpers\Taxonomy;

	return $taxonomy->getTaxonomies($terms);
}

/**
 * Get the starship collection
 * @return false|mixed
 */
function starship_get_collection($post_type = null)
{
	$collection = new Starship\Helpers\Collection();

	return $collection->getCollection($post_type);
}
