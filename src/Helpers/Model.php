<?php


namespace Starship\Helpers;


class Model
{
	public function init()
	{
		foreach ($this->getTheModels() as $class) {
			if (class_exists($class)){

				$class::init();
			}
		}
	}

	public function __construct()
	{
		self::init();
		add_action('the_post', [$this, 'overwriteWPObject']);
	}

	public function overwriteWPObject($object)
	{

		$GLOBALS[STARSHIP_GLOBAL_POST] = $this->getPost($object);

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
		return $GLOBALS[STARSHIP_GLOBAL_POST] ?? false;
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
		$models = $this->unsetValueOfArray('index.php', $models);
		$models = $this->stripPartOfArrayValue('.php', $models);

		return $this->getClasses('Starship\Models\\', $models);
	}

	/**
	 * Generate the classes
	 *
	 * @param string $namespace
	 * @param array $classes
	 *
	 * @return array
	 */
	private function getClasses(string $namespace, array $classes): array
	{
		foreach ($classes as &$class) {
			$class = $namespace . $class;
		}

		return $classes;
	}

	/**
	 * Unset item by value
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	private function unsetValueOfArray(string $value, array $items): array
	{
		if (($key = array_search($value, $items)) !== false) {
			unset($items[$key]);
		}

		return $items;
	}

	/**
	 * Strip part of value in array
	 *
	 * @param string $value
	 * @param array $items
	 *
	 * @return array
	 */
	private function stripPartOfArrayValue(string $value, array $items): array
	{
		foreach ($items as &$item) {
			$item = str_replace($value, '', $item);

		}

		return array_values($items);

	}

}
