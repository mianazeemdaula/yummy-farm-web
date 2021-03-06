<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        } else {
            $user = new User;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            // $user->name = $request->name;
            $user->role = $request->role;
            if($request->role == 'seller'){
                $count = User::where('role', 'seller')->count() + 1;
                $user->seller_number = sprintf('%03d', $count);
            }
            $user->save();
            $user->tokens()->delete();
            $user = User::find($user->id);
            $token = $user->createToken('Auth Token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|string',
                'password' => 'required|string|min:4',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()], 200);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $token = $user->createToken('Auth Token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        }
        return response()->json(['messasge' => 'Wrong credientals'], 204);;
    }



    public function sociallogin(Request $request)
    {
        try {
            $user = Socialite::driver($request->driver)->userFromToken($request->token);
            $authUser = User::where('email', $user->getEmail())->first();
            if ($authUser) {
                Auth::login($authUser);
                $authUser->tokens()->delete();
                $token = $authUser->createToken('Auth Token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $authUser], 200);
            } else {
                $authUser = new User;
                $authUser->name = $user->name;
                $authUser->email = $user->email;
                $authUser->social_id = $user->id;
                $authUser->email_verified_at = Carbon::now();
                $authUser->image = $user->getAvatar();
                if($request->has('role') && $request->role == 'seller'){
                    $count = User::where('role', 'seller')->count() + 1;
                    $authUser->seller_number = sprintf('%03d', $count);
                }
                $authUser->role = $request->role;
                $authUser->save();
                Auth::login($authUser);
                $authUser->tokens()->delete();
                $token = $authUser->createToken('Auth Token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $authUser], 200);
            }
        } catch (Exception $ex) {
            return response()->json(['error' => $ex], 204);
        }
    }

    public function socialcallback(Request $request)
    {
        return $request->all();
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $credentials = ['email' => $request->email];
        $response = Password::sendResetLink($credentials, function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return response()->json(['messasge' => 'Reset password link sent succesfully'], 200);
            case Password::INVALID_USER:
                return response()->json(['messasge' => 'Invalid user'], 204);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();
                // event(new PasswordReset($user));
            }
        );
        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }
        return response([
            'message'=> __($status)
        ], 500);
    }


    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        if ($request->has('image')) {
            $name = 'images/' . Str::random(40) . '.' . $request->image->getClientOriginalExtension();
            Image::make($request->image)->resize(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            })->save($name);
            $user->image = $name;
        }
        $user->save();
        return response()->json(['status' => true, 'data' => $user], 200);
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            if ($request->has('fcm_token')) {
                $user->fcm_token = $request->fcm_token;
            }
            if ($request->has('name')) {
                $user->name = $request->name;
            }if ($request->has('business_name')) {
                $user->business_name = $request->business_name;
            }
            if ($request->has('firstname')) {
                $user->firstname = $request->firstname;
            }if ($request->has('username')) {
                $user->username = $request->username;
            }if ($request->has('address')) {
                $user->address = $request->address;
            }if ($request->has('address_line_2')) {
                $user->address_line_2 = $request->address_line_2;
            }if ($request->has('country')) {
                $user->country = $request->country;
            }if ($request->has('phone')) {
                $user->phone = $request->phone;
            }if ($request->has('vat')) {
                $user->vat = $request->vat;
            }if ($request->has('bank_account')) {
                $user->bank_account = $request->bank_account;
            }if ($request->has('rpr')) {
                $user->rpr = $request->rpr;
            }if ($request->has('status')) {
                $user->status = $request->status;
            }if ($request->has('description')) {
                $user->description = $request->description;
            }if ($request->has('notifications')) {
                $user->enable_notification = $request->notifications;
            }if ($request->has('lang')) {
                $user->lang = $request->lang;
            }if ($request->has('lat') && $request->has('lng')) {
                $user->location = new Point($request->lat, $request->lng);
            }
            $user->save();
            $user = User::find($user->id);
            return response()->json(['status' => true, 'data' => $user], 200);
        } catch (Exception $ex) {
            return response()->json(['messasge' => $ex], 500);
        }
    }

    public function user(Request $request)
    {
        $user = User::find($request->user()->id);
        $data['user'] = $user;
        // if($user->role == 'seller'){
        //     $data['categories'] = Category::all();
        // }
        return response()->json($data);
    }

}
