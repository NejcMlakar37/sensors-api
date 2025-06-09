<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserPasswordChangeRequest;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @param UserLoginRequest $request
     * @return mixed
     */
    public function login(UserLoginRequest $request): mixed
    {
        $user = User::query()->with('company')->where('email', $request->get('email'))->first();
        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return back()->withErrors(['message' => "Napačno uporabniško ime ali geslo!"]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return Inertia::location(route('home'));
    }

    /**
     * @param UserPasswordChangeRequest $request
     * @return mixed
     */
    public function passwordChange(UserPasswordChangeRequest $request): mixed
    {
        $user = User::query()->where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->old_password, $user->password)) {
            return response()->error('Nepravilno geslo ali e-mail!');
        }

        $user->password = $request->input('new_password');

        if($user->save()) {
            $user->tokens()->delete();
            $token = $user->createToken('user-token', [], null, Str::random(32));
            return response()->success(['message' => $token]);
        } else {
            return response()->error('Prišlo je do napake pri posodabljanju gesla!');
        }
    }

    public function homePage(): Response
    {
        $sensors = Sensor::query()->with('latestMeasurement')->get();
        return Inertia::render('Home', [
            'sensorsWithLatest' => $sensors,
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request): mixed
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Inertia::location(route('login'));
    }
}
