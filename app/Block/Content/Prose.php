<?php

namespace Asylum\Theme\Block\Content;

use Asylum\Block\BlockController;

class Prose extends BlockController
{
    protected ?string $name = 'prose';

    protected ?string $label = 'Prose';

    protected string $category = 'asylum-content';

    protected string $icon = 'text-page';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];
}
