<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('favorites.index', [
            'favorites' => Favorite::where('user_id', Auth::id())->where('page_type', 'pages')->get()
        ]);
    }

    /**
     * @param Request $request
     * @param App\Models\Favorite $favorite
     * 
     * @return RedirectResponse
     */
    public function store(Favorite $favorite, Request $request)
    {
        $favorite->create([
            'user_id' => Auth::id(),
            'page_id' => $request->page_id,
            'page_type' => $request->page_type
        ]);

        return redirect()->back();
    }

    /**
     * @param int $id
     * 
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return redirect()->back();
    }
}
