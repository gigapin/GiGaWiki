<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\AccountMailJob;
use App\Mail\AccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AccountMailController extends Controller
{
    public function sendMail()
    {
        $user = User::findOrFail(auth()->id());
        
        AccountMailJob::dispatch($user);

        return redirect('dashboard');
    }
}
