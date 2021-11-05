<?php

namespace RT\RadiusBlocks\Blocks;

use RT\RadiusBlocks\Abstracts\Block;

class RtPosts extends Block
{
    protected $name = 'rt-radius-blocks/posts';

    public function __construct() {
    }

    public static function render_callback($attrs) {
        $limit = !empty($attrs['limit']) ? absint($attrs['limit']) : 10;

        $post_ids = get_posts([
            'post_per_page' => $limit,
            'fields'        => 'ids'
        ]);

        ob_start();
        ?>
        <h2>Radius post from php</h2>
        <?php
        if (!empty($post_ids)) {
            ?>
            <ul><?php
            foreach ($post_ids as $id) {
                ?>
                <li><?php echo get_the_title($id) ?></li>
                <?php
            }
            ?></ul><?php

        }
        return ob_get_clean();
    }
}