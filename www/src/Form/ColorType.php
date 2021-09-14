<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Wandi\ColorPickerBundle\Form\Type\ColorPickerType;
use Wandi\ColorPickerBundle\PickerOptions\Theme;

class ColorType extends ColorPickerType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $options['pickr_options'] = array_merge($options['pickr_options'], [
            'theme' => Theme::CLASSIC,
            'lockOpacity' => true,
        ]);

        parent::buildView($view, $form, $options);
    }
}
