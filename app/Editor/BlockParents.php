<?php

namespace Asylum\Theme\Editor;

use WP_Screen;
use WP_Block_Type_Registry;

class BlockParents
{
    /**
     * Constraints, keyed by post type then block name.
     *
     * @var array<string, array<string, array>>
     */
    private array $constraints = [
        'page' => [
            'core/paragraph' => [
                'parent' => [
                    'acf/content-section'
                ],
            ],
            'core/list' => [
                'parent' => [
                    'acf/content-section'
                ]
            ],
        ],
    ];

    public function __construct()
    {
        // add_filter('allowed_block_types_all', function())
        add_action('current_screen', [$this, 'setConstraints']);
    }

    /**
     * Apply the constraints for the post type being edited.
     *
     * Runs after set_current_screen() and before edit-form-blocks.php
     * renders the block definitions into the page, so the mutated
     * registry is what the editor bootstraps from.
     *
     * @param WP_Screen $screen
     * @return void
     */
    public function setConstraints(WP_Screen $screen): void
    {
        if ($screen->base !== 'post' || !$screen->is_block_editor()) {
            return;
        }

        //
        if (
            isset($_GET['post'])
            && $template = get_post_meta((int) $_GET['post'], '_wp_page_template', true)
        ) {
            // hacky, should check this better but ok as only have one!
            if (basename($template) === 'template-policy.twig') {
                return;
            }
        }

        $registry = WP_Block_Type_Registry::get_instance();

        foreach ($this->constraints[$screen->post_type] ?? [] as $name => $props) {
            if (!$block = $registry->get_registered($name)) {
                continue;
            }

            foreach ($props as $prop => $value) {
                $block->$prop = $value;
            }
        }
    }
}
