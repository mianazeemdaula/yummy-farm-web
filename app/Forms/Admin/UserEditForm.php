<?php

namespace App\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserEditForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ])
        ->add('image', 'file',  [
            'rules' => 'image|mimes:jpeg,png,jpg',
            'label' => 'Image'
        ])
        ->add('email', 'text',  [
            'rules' => 'required|unique:users,email,'.$this->getModel()->id.'|email',
            'label' => 'Email'
        ]);
    }
}
