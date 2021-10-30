<?php

namespace App\Forms\Admin;

use App\Category;
use Kris\LaravelFormBuilder\Form;


class MenuForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ])
        ->add('category_id', 'select',  [
            'choices' => Category::all()->pluck('name', 'id')->toArray(),
            'label' => 'Category'
        ])->add('active', 'choice', [
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
