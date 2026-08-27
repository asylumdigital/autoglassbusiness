<?php

namespace Asylum\Theme\Block\Media;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Video extends BlockController
{
    protected ?string $name = 'video';

    protected string $category = 'asylum-media';

    protected string $icon = 'video-alt3';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addWysiwyg('introduction', [
                "toolbar" => "content",
            ])
            ->addSelect('provider', [
                'choices' => [
                    'youtube' => 'YouTube',
                    'vimeo' => 'Vimeo',
                    'direct' => 'Uploaded Video'
                ],
            ])
            ->addText('youtube_id')
                ->conditional('provider', '==', 'youtube')
            ->addText('vimeo_id')
                ->conditional('provider', '==', 'vimeo')
            ->addFile('video_file', [
                'mime_types' => 'mp4,webm',
            ])
                ->conditional('provider', '==', 'direct')
            ->addImage('poster', [
                'preview_size' => 'thumbnail',

            ])
            ->addSelect('layout', [
                'choices' => [
                    'centre' => 'Central',
                    'left' => 'Video Left',
                    'right' => 'Video Right',
                ]
            ])
                ->setWidth(50)
            ->addSelect('style', [
                'choices' => [
                    'white' => 'White',
                    'dark' => 'Dark',
                    'highlight' => 'Highlight',
                ]
            ])
                ->setWidth(50)
            ;
        return $fields;
    }
}
