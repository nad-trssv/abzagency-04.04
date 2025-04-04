<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable= [ 'name', 'email', 'phone', 'photo', 'position_id' ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
