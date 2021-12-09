<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Models\User;
use App\Forms\Admin\UserForm;
use App\Forms\Admin\UserEditForm;
use App\Forms\User\ChangePasswordForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class SellerController extends Controller
{
    use FormBuilderTrait;
    public function index()
    {
        $collection = User::where('id','>',2)->where('role','seller')->get();
        return view('admin.seller.index', compact('collection'));
    }

    public function create()
    {
        $form = $this->form(UserForm::class, [
            'method' => 'POST',
            'class' => 'form-horizontal',
            'url' => route('seller.store')
        ]);
        return view('admin.seller.create', compact('form'));
    }

    public function store(Request $request)
    {
        $form = $this->form(UserForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($request->has('image')) {
            $name = 'images/' . Str::random(40) . '.' . $request->image->getClientOriginalExtension();
            Image::make($request->image)->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($name);
            $user->image = $name;
        }
        $user->save();
        return redirect()->route('seller.index')->with('status', 'Seller Created Successfully!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $form = $this->form(UserEditForm::class, [
            'method' => 'PUT',
            'class' => 'form-horizontal',
            'url' => route('seller.update', [$id]),
            'model' => $user
        ]);

        return view('admin.seller.edit', compact('form', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $form = $this->form(UserEditForm::class, ['model' => $user]);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user->name = $request->name;
        $user->firstname = $request->firstname;
        $user->username = $request->username;
        $user->business_name = $request->business_name;
        $user->address = $request->address;
        $user->address_line_2 = $request->address_line_2;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->vat = $request->vat;
        $user->bank_account = $request->bank_account;
        $user->rpr = $request->rpr;
        $user->status = $request->status;
        // $user->email = $request->email;
        // if ($request->has('image')) {
        //     // if ($user->media != null) {
        //     // if ($user->image != null) {
        //     //     // $url = $user->media->url;
        //     //     // $user->media()->delete();
        //     //     File::delete($user->image);
        //     // }
        //     $name = 'images/' . Str::random(40) . '.' . $request->image->getClientOriginalExtension();
        //     Image::make($request->image)->resize(400, 400, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })->save($name);
        //     $user->image = $name;
        // }
        $user->save();
        return redirect()->back()->with('status', 'Seller Updated!');
    }

    public function show(User $user)
    {
        return view('admin.seller.view', compact('user'));
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('status', 'Seller Deleted!');
    }

    
}
