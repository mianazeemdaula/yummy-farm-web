<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use App\Forms\Admin\CategoryForm;

class SubCategoryController extends Controller
{
    use FormBuilderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $collection = Category::where('super_category_id',$id)->get();
        return view('admin.subcategory.index', compact('collection', 'id'));
    }

    public function create($id)
    {
        $form = $this->form(CategoryForm::class, [
            'method' => 'POST',
            'class' => 'form-horizontal',
            'url' => route('sub.category.store',$id)
        ]);
        return view('admin.subcategory.create', compact('form'));
    }

    public function store(Request $request, $id)
    {
        $form = $this->form(CategoryForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $category = new Category();
        $category->name = $request->name;
        $category->super_category_id = $id;
        $category->save();
        return redirect()->route('sub.category.index', $id)->with('status', 'SubCategory Created Successfully!');
    }

    public function edit($cat, $id)
    {
        $category = Category::findOrFail($id);
        $form = $this->form(CategoryForm::class, [
            'method' => 'PUT',
            'class' => 'form-horizontal',
            'url' => route('sub.category.update', [$cat,$id]),
            'model' => $category
        ]);

        return view('admin.subcategory.edit', compact('form', 'category'));
    }

    public function update(Request $request, $cat, $id)
    {
        $form = $this->form(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('status', 'SubCategory Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InstrumentCategory  $instrumentCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($cat, $id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('status', 'SubCategory Deleted!');
    }
}
