<?php

/**
 * @package Wp Blocks
 * Plugin Name: Wp Blocks
 * Plugin URI:
 * Description: Custom Blocks for Bloggers and Marketers. Create Better Content With Gutenberg.
 * Author: Wp Blocks
 * Author URI:
 * Version: 0.0.1
 * License: GPL3+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: wp-blocks
 * Domain Path: /languages
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

defined('ABSPATH') || exit('Keep Silent');

// Define WP_BLOCKS_PLUGIN_FILE.
define('WP_BLOCKS_VERSION', '0.0.1');
define('WP_BLOCKS_FILE', __FILE__);

if (! class_exists('WPBlocks')) {
	require_once 'app/WPBlocks.php';
}
