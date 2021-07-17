<?php

namespace Starship\Models;

use Starship\Helpers\Collection;

/**
 *
 * Create the base model.
 * This can be extended for the post_types that need this model
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class BaseModel
{
	/**
	 * Set post_type for this model
	 */
	public const CPT = 'base_model';
	/**
	 * Set taxonomy for this post_type
	 */
	public const TAXONOMY = 'base_tax';

	/**
	 * @var WP_Post|\WP_Post
	 */
	protected $post;
	/**
	 * Permalink
	 * @var string
	 */
	protected $_link;
	/**
	 * @var null
	 */
	private $_primary_taxonomy;

	/**
	 * Product constructor.
	 *
	 * @param \WP_Post $post Post
	 */
	public function __construct($post)
	{
		$this->post = $post;
	}

	/**
	 * Init for hooks/filters functions
	 */
	public static function preInit()
	{
		self::init();
	}

	/**
	 * Init for hooks/filters functions
	 */
	public static function init()
	{

	}

	/**
	 * Add add_action to model
	 *
	 * @param string $tag
	 * @param callable $function_to_add
	 * @param int $priority
	 * @param int $accepted_args
	 */
	protected static function addAction(
		string $tag,
		callable $function_to_add,
		int $priority = 10,
		int $accepted_args = 1
	) {
		add_action($tag, $function_to_add, $priority, $accepted_args);
	}

	/**
	 * Add addFilter to model
	 *
	 * @param string $tag
	 * @param callable $function_to_add
	 * @param int $priority
	 * @param int $accepted_args
	 */
	protected static function addFilter(
		string $tag,
		callable $function_to_add,
		int $priority = 10,
		int $accepted_args = 1
	) {
		add_filter($tag, $function_to_add, $priority, $accepted_args);
	}

	/**
	 * Get the post object
	 * @return WP_Post|\WP_Post
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * Return post id
	 * @return int
	 */
	public function getId(): int
	{
		return $this->getPost()->ID;
	}

	/**
	 * Get the author
	 * @return int|string
	 */
	public function getAuthor()
	{
		return $this->getPost()->post_author;
	}

	/**
	 * Get the post title of the post.
	 */
	public function getPostTitle()
	{
		return $this->getPost()->post_title;
	}

	/**
	 * Set the post title of the post.
	 */
	public function setPostTitle($status)
	{
		$this->updateDefaultPostValue('post_title', $status);
	}

	/**
	 * Get the author of the post
	 * @return int|string
	 */
	public function getPostAuthor()
	{
		return $this->getPost()->post_author;
	}

	/**
	 * Get the author user of the post
	 * @return false|\WP_User
	 */
	public function getPostAuthorObject()
	{
		return get_user_by('id', $this->getPostAuthor());
	}

	/**
	 * Get the author of the post
	 */
	public function setPostAuthor($id)
	{
		$this->updateDefaultPostValue('post_author', $id);
	}

	/**
	 * Get the post status of the post.
	 * @return string
	 */
	public function getPostStatus(): string
	{
		return $this->getPost()->post_status;
	}

	/**
	 * Set the post status of the post.
	 */
	public function setPostStatus($status)
	{
		$this->updateDefaultPostValue('post_status', $status);
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getType(): string
	{
		return self::CPT;
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getPostType(): string
	{
		return $this->getType();
	}

	/**
	 * Get the post_type of post
	 *
	 * @param string $post_type
	 *
	 * @return string
	 */
	public function setPostType(string $post_type): string
	{
		$this->updateDefaultPostValue('post_type', $post_type);
	}

	/**
	 * Get the permalink of the post
	 * @return mixed
	 */
	public function getPermalink()
	{
		if ( ! $this->_link) {
			$this->_link = get_the_permalink($this->post);
		}

		return $this->_link;
	}

	/**
	 * Get the post_type of post
	 * @return string
	 */
	public function getLink(): string
	{
		return $this->getPermalink();
	}

	/**
	 * Get primary category
	 * @return WP_Error|WP_Term|WP_Term[]|\WP_Term|null
	 */
	public function getPrimaryCategory()
	{
		if ( ! $this->_primary_taxonomy) {
			if ( ! empty($term = $this->getPrimaryTerm($this::TAXONOMY))) {
				$this->_primary_taxonomy = $term;
			} else {
				$this->_primary_taxonomy = null;
			}
		}

		return $this->_primary_taxonomy;
	}

	/**
	 * Get the main taxonomy of a post.
	 *
	 * @param string $taxonomy The name of the taxonomy
	 * @param WP_Post|int $post The post or it's ID
	 *
	 * @return WP_Term|WP_Error The term or null if none found (or error on error)
	 */
	function getPrimaryTerm(string $taxonomy = 'category')
	{

		/** @var WP_Term[] $terms */
		$terms = get_the_terms($this->getId(), $taxonomy);
		if ($terms instanceof WP_Error) {
			return $terms;
		} elseif (empty($terms) || ! is_array($terms)) {
			return null;
		}

		// Check if Yoast SEO is enabled / exists and if there are multiple terms to choose from
		if (count($terms) > 1 && class_exists('WPSEO_Primary_Term')) {

			// Resolve the ID of the primary term
			$primary = new WPSEO_Primary_Term($taxonomy, $this->getId());
			$term_id = $primary->get_primary_term();

			// Find the term with the same ID
			if ($term_id !== false) {
				foreach ($terms as $term) {
					if ($term_id === $term->term_id) {
						return $term;
					}
				}
			}

		}

		// Fallback: return the first option
		return $terms[0];
	}

	/**
	 * Function over the default wp_update_post to make it easier to update data.
	 *
	 * @param string $key
	 * @param $value
	 */
	protected function updateDefaultPostValue(string $key, $value)
	{
		wp_update_post([
			'ID' => $this->post->ID,
			$key => $value
		]);
	}

	/**
	 * Function over the default update_post_meta to make it easier to update data.
	 *
	 * @param string $key
	 * @param $value
	 */
	protected function updatePostMetaValue(string $key, $value): void
	{
		update_post_meta($this->getId(), $key, $value);
	}

	/**
	 * Function over the default get_post_meta to make it easier to update data.
	 *
	 * @param string $key
	 * @param bool $single
	 *
	 * @return mixed
	 */
	protected function getPostMetaValue(string $key, $single = true)
	{
		return get_post_meta($this->getId(), $key, $single);
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
		return get_field($selector, $this->getId());
	}

	/**
	 * Get fields of current post
	 *
	 * @return mixed
	 */
	public function getFields()
	{
		return get_field($this->getId());
	}
	public function getCollection()
	{
		$model = new Collection();
		return $model->getCollection($post);
	}
}
