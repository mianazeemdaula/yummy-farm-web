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
use App\Models\Tutor;
use App\Models\Student;
use App\Models\TutorVideos;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            // 'name' => 'required|string|min:4|max:150',
        ]);
        if ($validator->fails()) {
            return response()->json(['required' => $validator->errors()->first()], 200);
        } else {
            $user = new User;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            // $user->name = $request->name;
            $user->role = $request->role;
            $user->save();
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
                $token = $authUser->createToken('Auth Token')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $authUser], 200);
            } else {
                $authUser = new User;
                $authUser->name = $user->name;
                $authUser->email = $user->email;
                $authUser->social_id = $user->id;
                $authUser->email_verified_at = Carbon::now();
                $authUser->image = $user->getAvatar();
                Auth::login($authUser);
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
            $isTutor = $user->hasRole('tutor');
            if ($request->has('fcm_token')) {
                $user->fcm_token = $request->fcm_token;
            }
            $user->save();
            return response()->json(['status' => true, 'data' => $user], 200);
        } catch (Exception $ex) {
            return response()->json(['messasge' => $ex], 500);
        }
    }

}
