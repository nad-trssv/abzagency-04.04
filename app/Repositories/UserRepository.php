<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * Returns paginated users list
     */
    public function listPaginated($perPage, $page): LengthAwarePaginator
    {
        return User::orderByDesc('id')->paginate($perPage);
    }
    
    /**
     * Create new user
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function showById(int $id): ?User
    {
        return User::find($id);
    }
}
