<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;


/*
*@group User Management
*API's to manage user resourses
*/ 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Gets a list of users
     * 
     * @queryParam page_size int Size per page. Defaults to 20
     * 
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $users = User::query()->paginate($request->page_size ?? 20);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, UserRepository $userRepository)
    {
        $created = $userRepository->create($request->only([
            'email',
            'name',
       ]));
        
       return new UserResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user, UserRepository $userRepository)
    {
        $updated = $userRepository->update($user, $request->only([
            'email',
            'name',
       ]));

       return new UserResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserRepository $userRepository)
    {
        $userRepository->forceDelete($user);

        return response()->json([
            'success' => 'record deleted successfully',
        ]);
    }
}
