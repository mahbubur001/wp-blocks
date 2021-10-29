<?php

namespace Ic\WpBlocks\Models;

use WP_Block_Type;

class TitleBlock extends WP_Block_Type
{
	private $id = 'ic-wp-blocks/title';

	private $attributes = [
		'fname'=> [
			'type'     => 'string',
			'default'  => '',
		],
	];

	public function __construct($data)
	{
	}
}
