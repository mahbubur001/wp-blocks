<?php

require_once __DIR__ . './../vendor/autoload.php';

defined('ABSPATH') || exit;

use RT\RadiusBlocks\Abstracts\Block;
use RT\RadiusBlocks\Helpers\Fns;
use RT\RadiusBlocks\Controllers\AssetsController;
use RT\RadiusBlocks\Helpers\Installer;
use RT\RadiusBlocks\Models\Dependencies;

final class RadiusBlocks
{
    /**
     * Store the singleton object.
     */
    private static $singleton = false;

    /**
     * Create an inaccessible constructor.
     */
    private function __construct() {
        $this->define_constants();
        $dependence = Dependencies::getInstance();
        //if ($dependence->check()) {
        $assets = new AssetsController();
        $assets->init();
        $this->init_hooks();
        //}
    }

    /**
     * Fetch an instance of the class.
     */
    final public static function getInstance() {
        if (false === self::$singleton) {
            self::$singleton = new self();
        }

        return self::$singleton;
    }

    public function on_plugins_loaded() {
        do_action('wp_blocks_loaded');
    }

    public function init() {
        $this->load_language();
        // Other hooks which is need to run all first
    }

    private function init_hooks() {

        register_activation_hook(RT_RADIUS_BLOCKS_FILE, [Installer::class, 'activate']);
        register_deactivation_hook(RT_RADIUS_BLOCKS_FILE, [Installer::class, 'deactivate']);
        register_shutdown_function([$this, 'log_errors']);
        add_action('plugins_loaded', array($this, 'on_plugins_loaded'), -1);
        add_action('init', [$this, 'register_blocks']);
        add_action('init', array($this, 'init'), 0);
    }

    public function register_blocks() {
        if (function_exists('register_block_type')) {
            $blocks = Fns::getRegisteredBlocks();
            if (!empty($blocks) && is_array($blocks)) {
                foreach ($blocks as $block) {
                    /** @var Block $loadedBlock */
                    $loadedBlock = is_string($block) ? new $block() : $block;
                    if (!$loadedBlock->getName()) {
                        continue;
                    }
                    register_block_type($loadedBlock->getName(), [
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
    public function get_assets_uri($file) {
        $file = ltrim($file, '/');

        return trailingslashit(RT_RADIUS_BLOCKS_URL . '/assets') . $file;
    }

    /**
     * @param $file
     *
     * @return string
     */
    public function get_dist_uri($file) {
        $file = ltrim($file, '/');

        return trailingslashit(RT_RADIUS_BLOCKS_URL . '/dist') . $file;
    }

    private function define_constants() {
        $this->define('RT_RADIUS_BLOCKS_DIR', plugin_dir_path(RT_RADIUS_BLOCKS_FILE));
        $this->define('RT_RADIUS_BLOCKS_URL', plugins_url('', RT_RADIUS_BLOCKS_FILE));
        $this->define('RT_RADIUS_BLOCKS_SLUG', basename(dirname(RT_RADIUS_BLOCKS_FILE)));
    }

    private function load_language() {
        $locale = determine_locale();
        $locale = apply_filters('plugin_locale', $locale, RT_RADIUS_BLOCKS_SLUG);
        unload_textdomain(RT_RADIUS_BLOCKS_SLUG);
        load_textdomain(RT_RADIUS_BLOCKS_SLUG, WP_LANG_DIR . '/' . RT_RADIUS_BLOCKS_SLUG . '/' . RT_RADIUS_BLOCKS_SLUG . '-' . $locale . '.mo');
        load_plugin_textdomain(RT_RADIUS_BLOCKS_SLUG, false, plugin_basename(dirname(RT_RADIUS_BLOCKS_FILE)) . '/languages');
    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  constant name
     * @param bool|string $value constant value
     */
    public function define($name, $value) {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    public function log_errors() {
        $error = error_get_last();
        do_action('rt_radius_blocks_shutdown_error', $error);
    }
}

/**
 * @return bool|RadiusBlocks
 */
function radiusBlocks() {
    return RadiusBlocks::getInstance();
}

radiusBlocks();
