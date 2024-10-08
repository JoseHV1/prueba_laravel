<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'regions';

    protected $hidden = [
        'status'
	];

	protected $fillable = [
        'id_reg',
		'description',
		'status',
	];
}
