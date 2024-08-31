<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $hidden = [
        'id',
		'password',
        'token',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token',
        'token',
        'expires_at',
	];

    public function generateToken(){
        $cadena = auth()->user()->email.''.date('Y-m-d H:i:s').''.rand(200, 500);
        return Hash::make($cadena);
    }
}
