<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class UserInvitedRegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(int $id, int $role_id)
    {
        $user = User::findOrFail($id);
        $role = Role::findOrFail($role_id);
        return view('auth.user-invited-register')
            ->with('user', $user)
            ->with('role', $role);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, int $id, int $role_id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user = User::findOrFail($id);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'slug' => Str::slug($request->name),
            'password' => Hash::make($request->password),
        ]);
        
        $role = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $role_id
        ]);
        if (! $role) {
            throw new \Exception('Role User cannot create');
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
