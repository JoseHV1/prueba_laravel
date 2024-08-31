<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'communes';

    protected $hidden = [
		'id_reg',
        'status'
	];

	protected $fillable = [
		'id_reg',
		'description',
		'status',
	];
}
