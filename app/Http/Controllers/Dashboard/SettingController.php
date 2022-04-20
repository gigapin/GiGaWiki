<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Page;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    protected array $keys = [
        'allow-public-access',
        'disable-comments',
        'enable-registration',
        'email-confirmation'
    ];

    /**
     * @return [type]
     */
    public function index()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.index', [
            'settings' => Setting::all()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return [type]
     */
    public function store(Request $request)
    {
        $this->authorize('create', Setting::class);

        $collection = collect($request->setting);

        foreach($this->keys as $value) {
            if ($collection->has($value)) {
                Setting::create([
                    'key' => $value,
                    'value' => 'true'
                ]);
            } else {
                Setting::create([
                    'key' => $value,
                    'value' => 'false'
                ]);
            }
        }

        return redirect()
            ->route('settings.security')
            ->with('success', 'Settings updated successfully');
    }

    /**
     * @return [type]
     */
    public function security()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.security', [
            'settings' => Setting::all()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return [type]
     */
    public function update(Request $request)
    {
        $this->authorize('update', Setting::class);

        $collection = collect($request->setting);

        foreach($this->keys as $value) {
            if ($collection->has($value)) {
                DB::table('settings')->where('key', $value)->update(['value' => 'true']);
            } else {
                DB::table('settings')->where('key', $value)->update(['value' => 'false']);
            }
        }

        return view('settings.security', [
            'settings' => Setting::all()
        ]);
    }

    /**
     * @return [type]
     */
    public function maintenance()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.maintenance');
    }

    /**
     * @return [type]
     */
    public function users()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.users', [
            'users' => User::all(),
        ]);
    }

    /**
     * @param string $slug
     * 
     * @return [type]
     */
    public function editUser(string $slug)
    {
        $this->authorize('update', Setting::class);

        $user = User::where('slug', $slug)->first();
        foreach($user->roles as $role) {
            $role = $role->name;
        }
        
        return view('settings.edit-user', [
            'user' => $user, 
            'role' => $role
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * 
     * @return [type]
     */
    public function updateUser(Request $request, string $slug)
    {
        $this->authorize('update', Setting::class);

        $user = User::where('slug', $slug)->first();
        $role = RoleUser::where('user_id', $user->id)->first();
        $roles['role_id'] = $request->roles[0];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        $user->update($data);
        $role->update($roles);

        return redirect()->route('settings.users');
    }

    /**
     * @return [type]
     */
    public function roles()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.roles', [
            'roles' => Role::all()
        ]);
    }

    /**
     * @return [type]
     */
    public function recycle()
    {
        $this->authorize('viewAny', Setting::class);

        return view('settings.recycle-bin', [
            'pages' => Page::onlyTrashed()->get(),
            'user' => User::loggedUser()
        ]);
    }

    /**
     * @return Illuminate|Application|View
     */
    public function deleteImages()
    {
        $this->authorize('delete', Setting::class);
        
        $images = Image::where('created_by', Auth::id())->get();
        $directory = '/uploads/' . Auth::id();
        $files = Storage::files($directory);

        return view('settings.delete-images', [
            'images' => $images,
            'files' => $files
        ]);
    }

    /**
     * @return RedirectResource
     */
    public function cleanupImages()
    {
        $images = Image::where('created_by', Auth::id())->get();
        
        foreach($images as $image) {
            if (Storage::exists($image->path)) {
                Storage::delete($image->path);
                $image->delete();
            } // else {
            //     $path = storage_path($image->path);
            //     dd($path);
            //     if (file_exists($path)) {
            //         unlink($path);
            //     }
            // }
        }

        return redirect()->route('settings.maintenance');
    }

    public function forceCleanupImages()
    {
        $directory = '/uploads/' . Auth::id();
        $files = Storage::files($directory);
        foreach($files as $file) {
            unlink(storage_path('app/public/') . $file);
        }

        return view('settings.maintenance');
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function forceDelete($id)
    {
        Page::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back();
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function restore($id)
    {
        Page::withTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    /**
     * @return [type]
     */
    public function emptyRecycleBin()
    {
        Page::onlyTrashed()->forceDelete();

        return redirect()->back();
    }
}
