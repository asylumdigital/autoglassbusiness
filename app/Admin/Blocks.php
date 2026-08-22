<?php

namespace Asylum\Theme\Admin;

use WP_Block_Type_Registry;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Blocks
{
    private $types = [
        'page',
        'post',
        'widget'
    ];

    public function __construct()
    {
        add_action('acf/init', [$this, 'registerPages']);

        foreach ($this->types as $type) {
            add_filter('acf/load_field/name=allowed_' . $type . '_block', [$this, 'options']);
        }

        add_filter('acf/load_field/name=block_usage_info_message', [$this, 'getBlockUsage']);

        $this->fields();
        // dd($config);
    }

    public function registerPages()
    {
        acf_add_options_page(
            [
                'page_title' 	=> 'Blocks',
                'menu_title'	=> 'Blocks',
                'menu_slug' 	=> 'manage-blocks',
                'parent_slug'   => 'options-general.php',
                'capability'	=> 'manage_options',
                'redirect'		=> false,
                'position'      => 4,
                // 'icon_url'      => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><g fill="none" fill-rule="evenodd"><path d="M18.933 24h-6.755S19.834 8.236 30.866 4c-6.98 9.412-11.933 20-11.933 20Zm10.134-.003h6.755S28.166 39.764 17.134 44c6.98-9.647 11.933-20 11.933-20v-.002Z" fill="currentColor" fill-rule="nonzero"/></g></svg>'),
            ]
        );
    }

    public function options(array $field): array
    {

        $field['choices'] = collect(WP_Block_Type_Registry::get_instance()->get_all_registered())->sortBy('category')->mapWithKeys(function($item, $key) {

            return [$key => sprintf('%s (%s)', $item->title ?: $item->name, $item->category)];
        })
        ->toArray();

        return $field;
    }

    public function fields()
    {
        $fields = new FieldsBuilder('block_support', []);


        foreach ($this->types as $type) {
            $fields->addTab('block_select_' . $type, [
                'label' => ucfirst($type),
            ])

            ->addCheckbox('allowed_' . $type . '_block', [
                'label' => ucfirst($type) . ' blocks',
                'required' => 0,
                'choices' => [],
                'allow_custom' => 0,
                'save_custom' => 0,
                'default_value' => [],
                'layout' => 'vertical',
                'toggle' => 1,
                'return_format' => 'value',
            ]);

        }



        $fields->setLocation('options_page', '==', 'manage-blocks');

        add_action('acf/init', function () use ($fields) {
            acf_add_local_field_group($fields->build());
        });
    }

    public function getBlockUsage($f)
    {
        $data = '<table class="form-table">%s</table>';

        $stats = '';
        global $wpdb;


        if (!$stats = get_transient('internal_block_usage')) {
            $stats = collect(WP_Block_Type_Registry::get_instance()->get_all_registered())
                ->filter(fn($item) => $item->category && strpos($item->category, 'asylum') !== false)
                ->map(function($item) use ($wpdb) {

                    $count = $wpdb->get_results(
                        $wpdb->prepare("SELECT ID FROM wp_posts WHERE post_content LIKE %s;", '%' . $wpdb->esc_like($item->name) . '%')
                    );


                    $links = '<div><a href="#" class="show-pages">Show/hide pages</a><p class="hidden block-pages">%s</p></div>';
                    $pages = [];

                    foreach ($count as $instance) {
                        $pages[] = sprintf('<a href="%s">%s</a> | <a href="%s">Edit</a><br />', get_permalink($instance->ID), get_the_title($instance->ID), get_edit_post_link( $instance->ID));
                    }

                    $links = sprintf($links, implode('', $pages));


                    return sprintf('<tr><th>%s</th><td><strong>%s</strong>%s</td></tr>', $item->title ?: $item->name, count($count), $links);
                })
                ->join('');

            set_transient( 'internal_block_usage', $stats, WEEK_IN_SECONDS);
        }

        $f['message'] = sprintf($data, $stats);
        return $f;
        // stash in a transient
        // dd(WP_Block_Type_Registry::get_instance()->get_all_registered());


    }
}
