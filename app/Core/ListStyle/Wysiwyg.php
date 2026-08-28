<?php

namespace Asylum\Theme\Core\ListStyle;

class Wysiwyg
{
    use Bullet;

    public function __construct()
    {
        add_filter('acf/format_value/type=wysiwyg', [$this, 'listStyles']);
        add_filter( 'wp_kses_allowed_html', [$this, 'acfAddSvgTag'], 10, 2);
    }

    public function listStyles(string $value): string
    {
        if (is_admin()) {
            return $value;
        }

        return $this->unorderedBullet($value);
    }

    public function acfAddSvgTag(array $tags, string $context): array
    {
        $tags['svg']  = [
            'xmlns'       => true,
            'fill'        => true,
            'viewbox'     => true,
            'viewBox'     => true,
            'role'        => true,
            'aria-hidden' => true,
            'focusable'   => true,
        ];
        $tags['path'] = [
            'd'    => true,
            'fill' => true,
            'stroke' => true,
            'stroke-width' => true,
        ];

        return $tags;
    }
}
