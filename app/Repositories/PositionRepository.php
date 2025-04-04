<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Support\Collection;

class PositionRepository
{
    /**
     * Create a new class instance.
     */
    public function getAll(): Collection
    {
        return Position::get();
    }
}
