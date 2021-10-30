<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

use App\Category;
use App\IngredientCategory;
use App\IngredientUnit;
use App\Menu;
use App\RecipeIngredient;

class RecipeForm extends Form
{
    public function buildForm()
    {
        $this->add('menu_id', 'select',  [
            'choices' => Menu::pluck('name', 'id')->toArray(),
            'label' => 'Menu',
        ])

        ->add('name', 'text',  [
            'rules' => 'required|min:2',
            'label' => 'Recipe Name'
        ])->add('image', 'file',  [
            'rules' => 'required|image|mimes:jpeg,png,jpg',
            'label' => 'Recipe Image'
        ])->add('description', 'textarea',  [
            'rules' => 'required|min:10',
            'label' => 'Description',
            'attr' => ['rows' => 3],
        ])->add('prepare_time', 'number',  [
            'rules' => 'required|min:1',
            'label' => 'Time'
        ])
        // ->add('serving', 'number',  [
        //     'rules' => 'required|min:1',
        //     'label' => 'Serving',
        //     'value' => 1,
        // ])
        ->add('ingredient_name', 'text',  [
            'label' => 'Ingredient',
        ])->add('ingredient_qty', 'number',  [
            'rules' => 'required|min:1',
            'label' => 'Quantity',
            'value' => 1,
        ])->add('ingredient_unit_id', 'select',  [
            'choices' => IngredientUnit::pluck('name', 'id')->toArray(),
            'label' => 'Unit',
        ])->add('ingredient_category_id', 'select',  [
            'choices' => IngredientCategory::pluck('name', 'id')->toArray(),
            'label' => 'Category',
        ])->add('instruction', 'text',  [
            'label' => 'Instruction'
        ]);
    }
}
