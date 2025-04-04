<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listPaginated($page = 1, $perPage = 6)
    {
        $data = $this->userRepository->listPaginated($perPage, $page);
        
        if($data->total() < 1){
            throw new \Exception('Page not found', 400);
        } 
        if($page > $data->lastPage())
        {
            throw new \Exception('Page not found', 400);
        }

        return $data;
    }

    public function store(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function show($id): User
    {
        if (is_numeric($id)) {
            $user = $this->userRepository->showById($id);
    
            if (!$user) {
                throw new Exception('User not found.', 404);
            }
        } else {
            throw new Exception("The user ID must be an integer.", 400);
        }
        
        return $user;
    }
}
