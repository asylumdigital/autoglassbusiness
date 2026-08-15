<?php

namespace Asylum\Theme\Core;

use DOMDocument;
use WP_Block;
use Timber\Timber;

class Block
{
    public function __construct()
    {
        add_filter('render_block_core/list', [$this, 'alterBlock'], 10, 3);
    }

    public function alterBlock(string $blockContent, array $block, WP_Block $instance)
    {

        $document = new DOMDocument();

        $document->loadHTML($blockContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $uls = $document->getElementsByTagName('ul');

        if (!$uls) {
            return $blockContent;
        }

        $listType = '';

        foreach ($uls as $ul) {
            $class = $ul->getAttribute('class');

            preg_match('/list--([a-zA-Z-_]+)/', $class, $matches);

            if (empty($matches[1])) {
                continue;
            }

            $listType = $matches[1];

            $ul->setAttribute('class', $class . ' pl-0 not-prose');

            $lis = $document->getElementsByTagName('li');

            foreach ($lis as $li) {
                $class = $li->getAttribute('class');
                $li->setAttribute('class', trim($class . ' flex gap-2 list-none pl-0'));
            }

            $blockContent = $document->saveHTML();
        }



        $blockContent = preg_replace('/(<li>)(.*)(<\/li>)/', '$1%s<span>$2</span>$3', $blockContent);

        // switch this base on the class
        $icon = Timber::compile('components/atoms/icons/list-check.twig');

        $blockContent = preg_replace('/(<li(.*)>)(.*)(<\/li>)/', '$1{icon}<span>$3</span>$4', $blockContent);

        $blockContent = str_replace('{icon}', $icon, $blockContent);

        return $blockContent;
    }
}
