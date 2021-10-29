<?php

namespace Ic\WpBlocks\Models;

abstract class Block
{
	/**
	 * The plugin name. Used for option names.
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * ID of the class extending the settings API. Used in option names.
	 *
	 * @var string
	 */
	public $attributes = [];

	protected $hasCallBack = false;

	/**
	 * Get iD of the class extending the settings API. Used in option names.
	 *
	 * @return  string
	 */
	public function getAttributes()
	{
		return is_array($this->attributes) ?
			$this->attributes :
			[];
	}

	/**
	 * Returns true if the block type is dynamic, or false otherwise. A dynamic
	 * block is one which defers its rendering to occur on-demand at runtime.
	 *
	 * @since 5.0.0
	 *
	 * @return bool Whether block type is dynamic.
	 */
	public function is_dynamic()
	{
		return is_callable($this->render_callback);
	}

	/**
	 * Get the plugin name. Used for option names.
	 *
	 * @return  string
	 */
	public function getName()
	{
		return $this->name;
	}
}
