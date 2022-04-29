<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Profiled;
use App\Events\UserAdded;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Subject;
use App\Models\Project;
use App\Models\Section;
use App\Models\Page;
use App\Models\RoleUser;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\EmailInvite;
use App\Http\Requests\Dashboard\UserRequest;
use App\Traits\HasUploadFile;

class UserController extends Controller
{
    use HasUploadFile;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(1);
        foreach($user->roles as $role) {
            echo $role->name;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password !== null) {
            $user->password = Hash::make($request->password);
        } else {
            $user->password = "";
        }
        
        $user->slug = Str::slug($request->name);
        $user->save();

        $role = new RoleUser();
        $role->user_id = $user->id;
        $role->role_id = $request->roles[0];
        $role->save();
        
        // If email confirmation is required send an email to new user
        $setting = Setting::where('key', 'email-confirmation')->first();

        if ($request->invite === 'on') {
            $this->dataEmailInvite($request);
            event(new Profiled($user));
        } elseif($setting->value !== null) {
            if ($setting->value === 'true') {
                event(new UserAdded($user));
            }
        }
        
        return redirect()
            ->route('settings.users')
            ->with('success', 'User created successfully');
    }

    private function dataEmailInvite(UserRequest $request)
    {
        $user = new EmailInvite();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->slug = Str::slug($request->name);
        $user->save();
    } 

    public function emailInvitation(User $user, int $id)
    {
        $user = $user->findOrfail($id);
        return view('users.invitation')->with('user', $user);
    }

    public function sendEmailVerifyFromEmailInvitation(User $user, int $id)
    {
        $user = $user->findOrfail($id);
        event(new UserAdded($user));

        return view('users.notify-verification-email')->with('user', $user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        return view('users.show')
            ->with('user', User::where('slug', $slug)->first())
            ->with('subject', Subject::where('user_id', Auth::id())->count())
            ->with('project', Project::where('user_id', Auth::id())->count())
            ->with('page', Page::where('created_by', Auth::id())->count())
            ->with('page_updated', Page::where('updated_by', Auth::id())->count());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $slug)
    {
        $user = User::where('slug', $slug)->first();
        foreach($user->roles as $role) {
            $role = $role->name;
        }
        
        return view('users.edit')
            ->with('user', $user)
            ->with('role', $role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $slug)
    {
        $user = User::where('slug', $slug)->first();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        if ($request->password !== null) {
            $data['password'] = Hash::make($request->password);
        }
        $data['slug'] = Str::slug($request->name);
        if ($request->hasFile('featured')) {
            $this->renderFeatured('featured');
            $data['image_id'] = $this->saveImageFeatured('featured', 'avatar')->id;
        }
        $user->update($data);

        return redirect()->route('users.show', $user->slug);
    }

    public function delete(int $id)
    {
        return view('users.delete')
            ->with('user', User::findOrFail($id));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('settings.users');
    }

    
}
