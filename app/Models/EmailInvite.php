<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailInvite extends Model
{
    use HasFactory;

    protected $table = 'email_invite';

    protected $fillable = [
        'name', 
        'email',
        'email_verified_at',
        'email_confirmed',
        'password',
        'slug'
    ];
}
