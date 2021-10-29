<?php

namespace Ic\WpBlocks\Helpers;

use Ic\WpBlocks\Models\TitleBlock;

class Fns
{
	public static function getRegisteredBlocks()
	{
		$blocks = [
			TitleBlock::class,
		];

		return apply_filters('ic_wp_blocks_registered_blocks', $blocks);
	}
}
