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
        ])->add('firstname', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'First Name'
        ])->add('username', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Username'
        ])->add('business_name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Business Name'
        ])->add('address', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Address'
        ])->add('address_line_2', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Address Line 2'
        ])->add('country', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Country'
        ])->add('phone', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Phone'
        ])->add('vat', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'VAT'
        ])->add('bank_account', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Bank Account'
        ])->add('rpr', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'RPR'
        ])
        ->add('status', 'select',  [
            'choices' => ['enable' => 'Enabled', 'disable' => 'Disable'],
            'label' => 'Status'
        ]);
    }
}
