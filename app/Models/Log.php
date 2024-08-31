<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

	protected $table = 'logs';

	protected $hidden = [
		'id',
	];

	protected $fillable = [
		'id_user',
		'action',
		'ip',
	];
}
