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
		if (static::registerPostType()) {
			static::registerThePostType();
		}
		static::init();
	}

	/**
	 * Init for hooks/filters functions
	 */
	public static function init()
	{

	}

	/**
	 * Set singular name for post_type
	 * @return string
	 */
	public static function postTypeSingularName(): string
	{
		return static::CPT;
	}

	/**
	 * Set name for post_type
	 * @return string
	 */
	public static function postTypeName(): string
	{
		return static::CPT;
	}

	/**
	 * Set rewrite slug for post_type
	 * @return string
	 */
	public static function postTypeRewriteSlug(): string
	{
		return static::CPT;
	}

	/**
	 * Set dashicon name for post_type
	 * @return string
	 */
	public static function postTypeMenuIcon(): string
	{
		return 'dashicons-dashboard';
	}

	/**
	 * Set support for post_type
	 * @return array
	 */
	public static function postTypeSupports(): array
	{
		return ['title', 'editor', 'excerpt'];
	}

	/**
	 * Toggle ui
	 * @return bool
	 */
	public static function postTypeShowUi(): bool
	{
		return true;
	}

	/**
	 * Set archive
	 * @return bool
	 */
	public static function postTypeHasArchive(): bool
	{
		return true;
	}

	/**
	 * Make post_type hierarchical
	 * @return bool
	 */
	public static function postTypeHierarchical(): bool
	{
		return false;
	}

	/**
	 * Set post_type public state
	 * @return bool
	 */
	public static function postTypePublic(): bool
	{
		return false;
	}

	/**
	 * Add rewrite settings
	 * @return array
	 */
	public static function postTypeRewrite(): array
	{
		return ['slug' => static::postTypeRewriteSlug(), 'with_front' => true];
	}

	/**
	 * Register post_type
	 */
	public static function registerThePostType()
	{
		$labels = [
			'name'               => __(sprintf('%s items', static::postTypeName()), STARSHIP_TEXT_DOMAIN),
			'singular_name'      => __(sprintf('%s item', static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
			'add_new'            => __('Nieuwe toevoegen', 'ecs-admin'),
			'add_new_item'       => __(sprintf('Nieuw %s item toevoegen', static::postTypeSingularName()),
				STARSHIP_TEXT_DOMAIN),
			'edit_item'          => __(sprintf('Bewerk %s item', static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
			'new_item'           => __(sprintf('Nieuw %s item', static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
			'view_item'          => __(sprintf('Bekijk %s item', static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
			'view_items'         => __(sprintf('Bekijk %s items', static::postTypeSingularName()),
				STARSHIP_TEXT_DOMAIN),
			'search_items'       => __(sprintf('Zoek %s items', static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
			'not_found'          => __(sprintf('Geen %s items gevonden', static::postTypeSingularName()),
				STARSHIP_TEXT_DOMAIN),
			'not_found_in_trash' => __(sprintf('Geen %s items gevonden in prullenbak',
				static::postTypeSingularName()), STARSHIP_TEXT_DOMAIN),
		];

		$options = [
			'public'       => static::postTypePublic(),
			'hierarchical' => static::postTypeHierarchical(),
			'has_archive'  => static::postTypeHasArchive(),
			'rewrite'      => static::postTypeRewrite(),
			'show_ui'      => static::postTypeShowUi(),
			'supports'     => static::postTypeSupports(),
			'menu_icon'    => static::postTypeMenuIcon(),
		];

		$options = apply_filters(STARSHIP_PREFIX . '_post_type_' . static::CPT . '_options', $options);
		$labels  = apply_filters(STARSHIP_PREFIX . '_post_type_' . static::CPT . '_labels', $labels);

		$options['labels'] = $labels;
		register_post_type(
			static::CPT,
			$options
		);

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
	 * Set value for field of current post
	 *
	 * @param string $selector
	 * @param $value mixed
	 *
	 * @return mixed
	 */
	public function updateField(string $selector, $value)
	{
		return update_field($selector, $value, $this->getId());
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

	/**
	 * @return bool
	 */
	public static function registerPostType(): bool
	{
		return false;
	}

	/**
	 * Get collection of this model if set
	 * @return false|mixed
	 */
	public function getCollection()
	{
		$collection = new Collection();

		return $collection->getCollection($this::CPT);
	}
}
