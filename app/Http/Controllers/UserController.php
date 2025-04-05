<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserPaginateRequest;
use App\Services\ImageOptimizationService;
use App\Services\PositionService;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UserPaginateRequest $request)
    {
        try {
            $page = $request->input('page', 1);
            $perPage = $request->input('count', 6);
            $data = $this->userService->listPaginated($page, $perPage);

            return view('users.index', [
                'success' => true,
                'page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
                'total_users' => $data->total(),
                'count' => $data->perPage(),
                'links' => [
                    'next_url' => $data->nextPageUrl(),
                    'prev_url' => $data->previousPageUrl(),
                ],
                'users' => $data,
            ]);
        } catch(Exception $exception) {
            return back()->withErrors(['error' => $exception->getMessage()])
                     ->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PositionService $positionService)
    {
        try {
            $data = $positionService->list();
            return view('users.create',[
                'positions' => $data,
            ]);
        } catch(Exception $exception) {
            return back()->with('error', $exception->getMessage())
                        ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
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

            $this->userService->store($data);
            return redirect()->route('users.index')->with('success', 'User added successful!');
        } catch (Exception $exception) {
            return back()->with('error', 'Failed to create the user: ' . $exception->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try { 
            $user = $this->userService->show($id);

            return view('users.show',[
                'success' => true,
                'user' => $user,
            ]);
        } catch (Exception $exception) {
            return redirect()->route('users.index')->with('error', 'User not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
