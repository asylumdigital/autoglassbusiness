<?php

namespace Asylum\Theme\Block\Form;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Iframed extends BlockController
{
    protected ?string $name = 'iframed';

    protected ?string $label = 'iFramed Form';

    protected string $category = 'asylum-form';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addSelect('form', [
                'choices' => [
                    'business-account-enquiry-webform' => 'Account Enquiry',
                    'business-account-opening-webform' => 'Account Opening',
                ],
            ])
                ->setWidth(50)
            ->addNumber('height', [
                'instructions' => 'Useful is the inner forms change. Will be set to 1500px for Account Enquiry and 2900px for Account Opening'
            ])
                ->setWidth(50);

        return $fields;
    }
}
