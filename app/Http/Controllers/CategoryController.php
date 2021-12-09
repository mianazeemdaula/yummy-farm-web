<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\Admin\CategoryForm;

class CategoryController extends Controller
{
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Category::whereNull('super_category_id')->get();
        return view('admin.category.index', compact('collection'));
    }

    public function create()
    {
        $form = $this->form(CategoryForm::class, [
            'method' => 'POST',
            'class' => 'form-horizontal',
            'url' => route('category.store')
        ]);
        return view('admin.category.create', compact('form'));
    }

    public function store(Request $request)
    {
        $form = $this->form(CategoryForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $category = new Category();
        $category->name = $request->name;
        $category->instrument_id = $request->instrument_id;
        $category->save();
        return redirect()->route('category.index')->with('status', 'Category Created Successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $form = $this->form(CategoryForm::class, [
            'method' => 'PUT',
            'class' => 'form-horizontal',
            'url' => route('category.update', [$id]),
            'model' => $category
        ]);

        return view('admin.category.edit', compact('form', 'category'));
    }

    public function update(Request $request, Category $category)
    {
        $form = $this->form(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('status', 'Category Updated!');
    }

    public function show(Category $unit)
    {
        return view('ingredient-unit.view', compact('unit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstrumentCategory  $instrumentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('status', 'Category Deleted!');
    }
}
