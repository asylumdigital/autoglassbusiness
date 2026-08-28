<?php

namespace Asylum\Theme\Core\ListStyle;

use DOMDocument;
use Timber\Timber;

trait Bullet
{
    protected $svgs = [
        'ticks' => [
            'attributes' => [
                'xmlns' => 'http://www.w3.org/2000/svg',
                'fill' => 'none',
                'viewbox' => '0 0 190 150',
            ],
            'paths' => [
                [
                    'stroke' => '#fff',
                    'stroke-width' => '33.27',
                    'd' => 'm11.23 72.72 58.2 53.29L177.33 11.4'
                ],
            ]
        ],
    ];
    public function unorderedBullet(string $content, string $type = 'ticks')
    {
        $document = new DOMDocument();

        $document->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $uls = $document->getElementsByTagName('ul');

        if (!$uls) {
            return $content;
        }

        $listType = '';

        foreach ($uls as $ul) {
            $class = $ul->getAttribute('class');

            preg_match('/list--([a-zA-Z-_]+)/', $class, $matches);

            if (empty($matches[1])) {
                continue;
            }

            $listType = $matches[1];

            $ul->setAttribute('class', $class . ' pl-0 not-prose space-y-4');

            $lis = $ul->getElementsByTagName('li');


            foreach ($lis as $li) {
                $class = $li->getAttribute('class');
                $li->setAttribute('class', trim($class . ' flex gap-2 list-none pl-0'));
            }

            if ($listType && ($this->svgs[$listType] ?? false)) {
                // The SVG element
                $svg = $document->createElement('svg');

                foreach($this->svgs[$listType]['attributes'] as $attribute => $value ) {
                    $svg->setAttribute($attribute, $value);
                }

                foreach ($this->svgs[$listType]['paths'] as $path) {
                    // The path element
                    $path = $document->createElement('path');

                    foreach ($path as $attribute => $value) {
                        $path->setAttribute($attribute, $value);
                    }

                    // Add the path to the SVG
                    $svg->appendChild($path);
                }

                foreach ($lis as $li) {
                    $listItem = $document->createElement('li');

                // //     dump($li->attributes);
                    foreach ($li->attributes as $attribute) {
                        $listItem->setAttribute( $attribute->name, $attribute->value );
                    }

                    $listItem->appendChild($svg);

                    $ul->removeChild($li);
                    $ul->appendChild($listItem);
                }
            }

            $content = $document->saveHTML();

            // if ($listType === 'ticks') {

            //     $content = preg_replace('/(<li>)(.*)(<\/li>)/', '$1%s<span>$2</span>$3', $content);

            //     // switch this base on the class
            //     $icon = Timber::compile('components/atoms/icons/list-check.twig');

            //     $content = preg_replace('/(<li(.*)>)(.*)(<\/li>)/', '$1{icon}<span>$3</span>$4', $content);

            //     $content = str_replace('{icon}', $icon, $content);
            // }
        }


        dd($content);
        return $content;
    }
}
