<?php

namespace Starship\Helpers;

class Model
{
	/**
	 * Init all the given models. For hooks and filters for example
	 */
	public function init()
	{
		foreach ($this->getTheModels() as $class) {
			if (class_exists($class)) {
				$class::preInit();
			}
		}
	}

	public function __construct()
	{
		self::init();
		add_action('the_post', [$this, 'addModelObject']);
	}

	/**
	 * Add model object to the global var
	 * @param $object
	 *
	 * @return mixed
	 */
	public function addModelObject($object)
	{

		$GLOBALS[STARSHIP_GLOBAL_MODEL] = $this->getPost($object);

		return $object;
	}

	/**
	 * Get the starship model
	 * @return false|mixed
	 */
	public function getPost($post = null)
	{
		if ($post === null) {
			return $this->getThePost();
		} elseif (is_int($post)) {
			return $this->getPostById($post);
		} elseif ($post instanceof \WP_Post) {
			return $this->getPostByPost($post);;
		} else {
			return false;
		}
	}

	/**
	 * Get posts
	 *
	 * @param $posts
	 *
	 * @return mixed
	 */
	public function getPosts($posts)
	{
		foreach ($posts as &$post) {
			$post = $this->getPost($post);
		}

		return $posts;
	}

	/**
	 * Get the post model by global
	 * @return false|mixed
	 */
	public function getThePost()
	{
		return $GLOBALS[STARSHIP_GLOBAL_MODEL] ?? false;
	}

	/**
	 * Get the post by id
	 *
	 * @param int $id
	 *
	 * @return false|mixed
	 */
	private function getPostById(int $id)
	{
		return $this->getPostByPost(get_post($id));
	}

	/**
	 * Get the post by WP post object
	 * @return false|mixed
	 */
	private function getPostByPost(\WP_post $post)
	{
		if (empty($post->post_type)) {
			return false;
		}

		$classes = $this->getTheModels();

		foreach ($classes as $class) {
			if ($class::CPT === $post->post_type) {
				return new $class($post);
			}
		}

		return false;
	}

	/**
	 * Get the models
	 * @return array|false
	 */
	private function getTheModels()
	{
		$models = array_diff(scandir(STARSHIP_PATH . 'src/Models'), array('.', '..'));
		if (empty($models)) {
			return false;
		}
		$models = BaseHelper::unsetValueOfArray('index.php', $models);
		$models = BaseHelper::stripPartOfArrayValue('.php', $models);


		$classes = BaseHelper::getClasses('Starship\Models\\', $models);

		return apply_filters(STARSHIP_PREFIX . '_classes_models', $classes);
	}

}
