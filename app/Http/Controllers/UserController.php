<?php

namespace App\Http\Controllers;

use App\Actions\Users\UpdateUserAction;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
         * get the users
         * their roles
         * and their clients (we'll add a count on the index table)
         * */
        $users = User::with(['role', 'clients'])
            ->orderBy('role_id')
            ->paginate(10);

        // Pass the paginated users to the 'users.index' view.
        return view('users.users-index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.users-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the user action
        try {
            $user = $updateUserAction->execute(array_merge($validated, ['id' => $user->id]));
        } catch (\Exception $e) {
            throw $e;
        }

        // redirect to the users show / edit page
        return Redirect::to("/users/{$user->id}")->with('status', 'user-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
