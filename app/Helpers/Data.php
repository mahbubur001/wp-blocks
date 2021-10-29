<?php

namespace Ic\WpBlocks\Helpers;

class Data
{
	public static function defaultBlocks()
	{
		return [
			'ic-wp-blocks/title'=> [
				'attributes'=> [
					'blockID' => [
						'type'    => 'string',
						'default' => '',
					],
				],
			],
		];
	}
}
