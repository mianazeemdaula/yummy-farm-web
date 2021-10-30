<?php

namespace App\Forms\Admin;

use Kris\LaravelFormBuilder\Form;


class InstrumentEditForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ])->add('image', 'file',  [
            'rules' => 'image|mimes:jpeg,png,jpg',
            'label' => 'Image'
        ])->add('status', 'choice', [
            'choices' => [true => 'Active', false => 'inActive'],
            'choice_options' => [
                'wrapper' => ['class' => 'choice-wrapper'],
                'label_attr' => ['class' => 'label-class'],
            ],
            'expanded' => false,
            'multiple' => false
        ]);

    }
}
