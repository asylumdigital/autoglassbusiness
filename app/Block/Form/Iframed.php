<?php

namespace Asylum\Theme\Block\Form;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Iframed extends BlockController
{
    protected ?string $name = 'iframed';

    protected ?string $label = 'iFramed Form';

    protected string $category = 'asylum-form';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addUrl('form');

        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        if (empty($data['form'])) {
            return;
        }

        $data['is_child'] = isset($args['ctx']['parent_fields']);
        $url = filter_var($data['form'], FILTER_VALIDATE_URL);
        $urlData = parse_url($url);

        $data['form'] = add_query_arg([
            'source' => esc_url(site_url()),
        ], $data['form']);

        $data['path'] = base64_encode($urlData['path'] ?? '/');
    }
}
