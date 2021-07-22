<?php

namespace Starship\ACF\Layouts;

/**
 *
 * Create the base layout model.
 *
 * @author  Joeri Abbo
 * @since   1.0.0
 */
class BaseLayout
{
	/**
	 * Set layout for this model
	 */
	public const LAYOUT = 'default';
	private $layout;
	private $index;

	public function __construct(array $layout, $index)
	{
		$this->layout = $layout;
		$this->index  = $index;
	}

	/**
	 * Get layout
	 * @return array
	 */
	public function getLayout(): array
	{
		return $this->layout;
	}

	/**
	 * Get layout index
	 * @return int
	 */
	public function getIndex(): int
	{
		return $this->index;
	}

	/**
	 * Get layout name
	 * @return string
	 */
	public function getLayoutName(): string
	{
		return $this->layout['acf_fc_layout'];
	}

}
