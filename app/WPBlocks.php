<?php

require_once __DIR__ . './../vendor/autoload.php';

use Ic\WpBlocks\Helpers\Fns;
use Ic\WpBlocks\Controllers\AssetsController;

final class WPBlocks
{
	/**
	 * Store the singleton object.
	 */
	private static $singleton = false;

	/**
	 * Create an inaccessible constructor.
	 */
	private function __construct()
	{
		$this->__init();
	}

	/**
	 * Fetch an instance of the class.
	 */
	final public static function getInstance()
	{
		if (false === self::$singleton) {
			self::$singleton = new self();
		}

		return self::$singleton;
	}

	private function __init()
	{
		$this->define_constants();
		$this->load_language();
		$assets = new AssetsController();
		$assets->init();
		$this->load_blocks();
	}

	private function load_blocks()
	{
		if (function_exists('register_block_type')) {
			$blocks = Fns::getRegisteredBlocks();
			if (! empty($blocks) && is_array($blocks)) {
				foreach ($blocks as $block) {
					/** @var Block $loadedBlock */
					$loadedBlock = is_string($block) ? new $block() : $block;

					register_block_type($loadedBlock->getName(), [
						'attributes'      => $loadedBlock->getAttributes(),
						'render_callback' => $loadedBlock->is_dynamic() ? [$block, 'render_callback'] : null,
					]);
				}
			}
		}
	}

	/**
	 * @param $file
	 *
	 * @return string
	 */
	public function get_assets_uri($file)
	{
		$file = ltrim($file, '/');

		return trailingslashit(WP_BLOCKS_URL . '/assets') . $file;
	}

	/**
	 * @param $file
	 *
	 * @return string
	 */
	public function get_dist_uri($file)
	{
		$file = ltrim($file, '/');

		return trailingslashit(WP_BLOCKS_URL . '/dist') . $file;
	}

	private function define_constants()
	{
		$this->define('WP_BLOCKS_PATH', plugin_dir_path(WP_BLOCKS_FILE));
		$this->define('WP_BLOCKS_URL', plugins_url('', WP_BLOCKS_FILE));
		$this->define('WP_BLOCKS_SLUG', basename(dirname(WP_BLOCKS_FILE)));
	}

	private function load_language()
	{
		$locale = determine_locale();
		$locale = apply_filters('plugin_locale', $locale, WP_BLOCKS_SLUG);
		unload_textdomain(WP_BLOCKS_SLUG);
		load_textdomain(WP_BLOCKS_SLUG, WP_LANG_DIR . '/' . WP_BLOCKS_SLUG . '/' . WP_BLOCKS_SLUG . '-' . $locale . '.mo');
		load_plugin_textdomain(WP_BLOCKS_SLUG, false, plugin_basename(dirname(WP_BLOCKS_FILE)) . '/languages');
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  constant name
	 * @param bool|string $value constant value
	 */
	public function define($name, $value)
	{
		if (! defined($name)) {
			define($name, $value);
		}
	}
}

	/**
	 * @return bool|WPBlocks
	 */
	function wpBlocks()
	{
		return WPBlocks::getInstance();
	}

	wpBlocks();
