<?php

namespace Asylum\Theme\Editor;

use Asylum\Config\Config\Config;

/**
 * List style options for both editors.
 *
 * Feeds the options from config/list-styles.php to the core/list block
 * inspector and to the TinyMCE listbox used by ACF WYSIWYG fields.
 * Both apply the class as `list--{slug}`.
 */
class ListStyles extends Config
{
    /**
     * Config name
     *
     * @var string
     */
    protected string $name = 'list-styles';

    /**
     * TinyMCE plugin/button handle
     *
     * @var string
     */
    protected const HANDLE = 'asylum_list_styles';

    /**
     * Register actions
     *
     * @return void
     */
    public function register(): void
    {
        add_action('enqueue_block_editor_assets', [$this, 'setBlockEditorAssets']);

        add_filter('mce_external_plugins', [$this, 'setEditorPlugin']);
        add_filter('tiny_mce_before_init', [$this, 'setEditorSettings']);
        add_filter('acf/fields/wysiwyg/toolbars', [$this, 'setToolbars']);
    }

    /**
     * The configured styles
     *
     * @return array
     */
    public function styles(): array
    {
        return $this->config['styles'] ?? [];
    }

    /**
     * Register the core/list select in the block editor.
     *
     * register_block_style() is not used: it always emits `is-style-{slug}`
     * with no way to set the class name.
     *
     * @return void
     */
    public function setBlockEditorAssets(): void
    {
        wp_enqueue_script(
            self::HANDLE,
            THEME_ABS_PATH . '/dist/js/block-list-styles.js',
            ['wp-blocks', 'wp-element', 'wp-hooks', 'wp-compose', 'wp-components', 'wp-block-editor'],
            THEME_VERSION,
            true
        );

        wp_add_inline_script(
            self::HANDLE,
            'window.asylumListStyles = ' . wp_json_encode($this->styles()) . ';',
            'before'
        );
    }

    /**
     * Register the TinyMCE listbox plugin
     *
     * @param array $plugins
     * @return array
     */
    public function setEditorPlugin(array $plugins): array
    {
        $plugins[self::HANDLE] = THEME_ABS_PATH
            . '/dist/js/tinymce-list-styles.js?ver=' . THEME_VERSION;

        return $plugins;
    }

    /**
     * Pass the styles through to the TinyMCE plugin.
     *
     * WordPress emits values that look like JSON arrays unquoted, so this
     * arrives in the editor as a real array on editor.settings.
     *
     * @param array $init
     * @return array
     */
    public function setEditorSettings(array $init): array
    {
        $init[self::HANDLE] = wp_json_encode($this->styles());

        return $init;
    }

    /**
     * Register the ACF WYSIWYG toolbar carrying the listbox
     *
     * @param array $toolbars
     * @return array
     */
    public function setToolbars(array $toolbars): array
    {
        $toolbars['Content'] = [
            1 => [
                'formatselect',
                self::HANDLE,
                'bold',
                'italic',
                'underline',
                'blockquote',
                'strikethrough',
                'bullist',
                'numlist',
                'undo',
                'redo',
                'link',
                'fullscreen',
            ],
        ];

        return $toolbars;
    }
}
