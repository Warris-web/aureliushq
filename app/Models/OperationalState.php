<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalState extends Model
{
    protected $fillable = [
        'state_id',
        'state_name',
    ];
}
