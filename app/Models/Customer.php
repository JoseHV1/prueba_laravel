<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;

class Customer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'customers';

    protected $casts = [
        'status' => Status::class
    ];

	protected $fillable = [
		'dni',
		'id_reg',
		'id_com',
		'email',
		'name',
		'last_name',
		'address',
		'date_reg',
		'status',
	];
}
