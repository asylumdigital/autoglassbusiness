<?php

namespace Asylum\Theme\Block\Widget;

use Asylum\Block\WidgetBlockController;

use StoutLogic\AcfBuilder\FieldsBuilder;

class CtaBox extends WidgetBlockController
{
    protected ?string $name = 'cta-box';

    /**
     * Allowed post types
     *
     * @var array
     */
    protected array $postTypes = [];

    /**
     * Block category
     *
     * @var string
     */
    protected string $category = 'asylum-widgets';

    protected array $headers = [];

    protected ?string $content = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Undocumented function
     *
     * @param FieldsBuilder $fields
     * @return FieldsBuilder
     */
    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('title');
        return $fields;
    }
}
