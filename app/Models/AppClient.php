<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppClient extends Model
{
    protected $fillable = ['expires_at', 'api_key'];
}
