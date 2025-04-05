<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserPaginateRequest;
use App\Http\Requests\UserShowRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShowResource;
use App\Services\ImageOptimizationService;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    public function index(UserPaginateRequest $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('count', 6);
            $data = $this->userService->listPaginated($page, $perPage);

            return response()->json([
                'success' => true,
                'page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'total_users' => $data->total(),
                'count' => $data->perPage(),
                'links' => [
                    'next_url' => $data->nextPageUrl(),
                    'prev_url' => $data->previousPageUrl(),
                ],
                'users' => UserResource::collection($data),
            ]);
        } catch(Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getCode() ?: 500);
        }
    }

    public function store(StoreUserRequest $request, ImageOptimizationService $imageOptimizationService)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $image = $request->file('photo');

                $path = $image->store('uploads/originals', 'public');
                $fullPath = storage_path('app/public/' . $path);

                $imagePath = $imageOptimizationService->optimizeImage($path, $fullPath);

                $data['photo'] = $imagePath;
            }

            $user = $this->userService->store($data);
            
            return response()->json([
                "success" => true,
                "user_id" => $user->id,
                "message" => "New user successfully registered"
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getCode() ?: 500);
        }
    }

    public function show($id)
    {
        try { 
            $user = $this->userService->show($id);

            return response()->json([
                'success' => true,
                'user' => new UserShowResource($user),
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getCode() ?: 500);
        }
    }
}
