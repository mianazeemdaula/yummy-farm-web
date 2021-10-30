<?php

namespace App\Forms\Admin;

use Kris\LaravelFormBuilder\Form;
use App\Models\Instrument;

class InstrumentCategoryForm extends Form
{
    public function buildForm()
    {
        $this
        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Name'
        ])->add('instrument_id', 'select',  [
            'choices' => Instrument::all()->pluck('name', 'id')->toArray(),
            'label' => 'Instrument'
        ]);

    }
}
