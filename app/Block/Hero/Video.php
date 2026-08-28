<?php

namespace Asylum\Theme\Block\Hero;

use Asylum\Block\BlockController;

class Video extends BlockController
{
    protected ?string $name = 'hero-video';

    protected ?string $label = 'TBC HERO';

    protected string $category = 'asylum-hero';

    protected ?string $template = 'block/hero/video';

    protected string $icon = 'format-video';
}
