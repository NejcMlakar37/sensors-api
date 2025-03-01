<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserPasswordChangeRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @param UserLoginRequest $request
     * @return mixed
     */
    public function login(UserLoginRequest $request): mixed
    {
        $user = User::query()->with(['company', 'role'])->where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->error('Nepravilno geslo ali e-mail!');
        }

        $user->tokens()->delete();
        $token = $user->createToken('user-token', [], now()->addDay(), Str::random(32));

        return response()->success(new AuthenticatedUserResource([
            'user' => $user,
            'token' => $token->plainTextToken
        ]));
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

    public function me(Request $request)
    {
        return response()->success(new AuthenticatedUserResource([
            'user' => $request->user()->load('role', 'company'),
            'token' => ''
        ]));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request): mixed
    {
        $request->user()->currentAccessToken()->delete();
        return response()->success(['message' => 'Izpis uspešen!']);
    }
}
