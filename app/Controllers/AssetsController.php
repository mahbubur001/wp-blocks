<?php

namespace Ic\WpBlocks\Controllers;

class AssetsController
{
	public function __construct()
	{
		$this->plugin_name = WP_BLOCKS_SLUG;
		$this->version     = WP_BLOCKS_VERSION;
	}

	public function init()
	{
		add_action('admin_enqueue_scripts', [&$this, 'admin_assets']);
		add_action('admin_enqueue_scripts', [&$this, 'enqueue_scripts']);
		add_action('enqueue_block_editor_assets', [&$this, 'editor_assets']);
	}

	public function admin_assets()
	{
		wp_enqueue_style($this->plugin_name, wpBlocks()->get_assets_uri('css/admin.css'), [], $this->version, 'all');
		wp_enqueue_script($this->plugin_name, wpBlocks()->get_assets_uri('js/admin.js'), ['jquery'], $this->version, false);
	}

	public function editor_assets()
	{

		// Scripts.
		wp_enqueue_script(
			$this->plugin_name . '-cgb-block-js',
			wpBlocks()->get_dist_uri('blocks.build.js'),
			['wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-api'],
			$this->version,
			true
		);

		wp_enqueue_script(
			$this->plugin_name . '-cgb-deactivator-js',
			wpBlocks()->get_dist_uri('deactivator.build.js'),
			['wp-editor', 'wp-blocks', 'wp-i18n', 'wp-element'],
			$this->version,
			true
		);

		// Styles.
		// if (file_exists(wp_upload_dir()['basedir'] . '/ultimate-blocks/blocks.editor.build.css') &&
		// get_option('ultimate_blocks_css_version') != $this->version) {
		// 	$adminStyleFile = fopen(wp_upload_dir()['basedir'] . '/ultimate-blocks/blocks.editor.build.css', 'w');
		// 	$blockDir       = dirname(__DIR__) . '/src/blocks/';
		// 	$blockList      = get_option('ultimate_blocks', false);

		// 	foreach ($blockList as $key => $block) {
		// 		$blockDirName = strtolower(str_replace(
		// 			' ',
		// 			'-',
		// 			trim(preg_replace('/\(.+\)/', '', $blockList[$key]['label']))
		// 		));
		// 		$adminStyleLocation = $blockDir . $blockDirName . '/editor.css';

		// 		if (file_exists($adminStyleLocation) && $blockList[$key]['active']) { //also detect if block is enabled
		// 			fwrite($adminStyleFile, file_get_contents($adminStyleLocation));
		// 		}
		// 		if ('ub/styled-box' === $block['name'] && $blockList[$key]['active']) {
		// 			//add css for blocks phased out by styled box
		// 			fwrite($adminStyleFile, file_get_contents($blockDir . 'feature-box' . '/editor.css'));
		// 			fwrite($adminStyleFile, file_get_contents($blockDir . 'number-box' . '/editor.css'));
		// 		}
		// 	}
		// 	fclose($adminStyleFile);
		// 	ub_update_css_version('editor');
		// }

		wp_enqueue_style(
			$this->plugin_name . '-cgb-block-editor-css',
			file_exists(wp_upload_dir()['basedir'] . '/' . $this->plugin_name . '/blocks.editor.build.css') ?
			content_url('/uploads/' . $this->plugin_name . '/blocks.editor.build.css') :
			wpBlocks()->get_dist_uri('blocks.editor.build.css'),
			['wp-edit-blocks'],
			$this->version
		);
	}
}
