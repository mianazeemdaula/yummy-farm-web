<?php

namespace App\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ])->add('image', 'file',  [
            'rules' => 'required|image|mimes:jpeg,png,jpg',
            'label' => 'Image'
        ])->add('email', 'text',  [
            'rules' => 'required|unique:users|email',
            'label' => 'Email'
        ])->add('password', 'password',  [
            'rules' => 'required|string|min:8|confirmed',
            'label' => 'Password'
        ])->add('password_confirmation', 'password',  [
            'rules' => 'required|string|min:8',
            'label' => 'Retype Password'
        ])
        ->add('role', 'select',  [
            'choices' => Role::all()->pluck('name', 'name')->toArray(),
            'label' => 'Rols'
        ]);

    }
}
