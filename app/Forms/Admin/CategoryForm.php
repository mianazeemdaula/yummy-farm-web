<?php

namespace App\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ]);

    }
}
