<?php

namespace App\Forms\User;

use Kris\LaravelFormBuilder\Form;

class ChangePasswordForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('old_password', 'password',  [
            'rules' => 'required|min:5',
            'label' => 'Old Password'
        ])->add('password', 'password',  [
            'rules' => 'required|min:5',
            'label' => 'New Passowrd'
        ])->add('retype_password', 'password',  [
            'rules' => 'required|min:5',
            'label' => 'Retype Password'
        ]);
    }
}
