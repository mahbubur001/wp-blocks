<?php

namespace RT\RadiusBlocks\Helpers;


use RT\RadiusBlocks\Blocks\RtPostReact;
use RT\RadiusBlocks\Blocks\RtPosts;
use RT\RadiusBlocks\Blocks\TitleBlock;

class Fns
{
    public static function getRegisteredBlocks() {
        $blocks = [
            RtPosts::class,
            RtPostReact::class,
            TitleBlock::class,
        ];

        return apply_filters('rt_radius_blocks_registered_blocks', $blocks);
    }
}
