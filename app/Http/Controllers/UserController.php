<?php

namespace App\Http\Controllers;

use App\Actions\ActivityLog\CreateActivityLog;
use App\Actions\Users\UpdateUserAction;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->select('id', 'name', 'role_id')
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
        /*
         * get roles of equal or lower level to the current user
         * stops an Admin from being able to assign someone to a Super Admin level
         * */
        $currentUserLevel = Auth::user()->role->level;
        $roles = Role::where('level', '<=', $currentUserLevel)
            ->select('id', 'name')
            ->get();

        return view('users.users-edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Exception
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction, CreateActivityLog $createActivityLog)
    {
        // validate the request
        $validated = $request->validated();

        // trigger the user action
        $action = $updateUserAction->execute(array_merge($validated, ['id' => $user->id]));

        // handle error
        if(!$action['success']) return Redirect::back()->withErrors(['error' => 'Failed to update user.']);

        // redirect to the users show / edit page
        return Redirect::to("/users/{$user->id}")->with('status', 'user-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // check the user is allowed to delete the resource
        if(!Auth::user()->isAdmin()) return Redirect::back()->withErrors(['error' => 'You do not have permission to delete this user.']);

        // delete the resource
        $user->delete();

        // return to users index
        return Redirect::to('/users')->with('status', 'user-deleted');
    }
}
