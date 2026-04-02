<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;

class UserController extends Controller implements HasMiddleware
{
    // Permission middleware for user management
    public static function middleware()
    {
        return [
            new Middleware(PermissionMiddleware::class . ':UserManagement-Index', only: ['index']),
            new Middleware(PermissionMiddleware::class . ':UserManagement-Create', only: ['create', 'store']),
            new Middleware(PermissionMiddleware::class . ':UserManagement-Edit', only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::class . ':UserManagement-Delete', only: ['destroy']),
            new Middleware(PermissionMiddleware::class . ':UserManagement-View', only: ['show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::where('id', '!=', Auth::id())
            ->latest('updated_at')
            ->withTrashed()
            ->get();
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('User creation request received.', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|array',
            'password' => 'required|string|min:8|same:confirm-password',
            'confirm-password' => 'required|string|min:8'
        ]);

        $input = $request->all();


        $input['password'] = Hash::make($input['password']);

        $roles = $input['roles'];
        unset($input['roles'], $input['confirm-password']);

        $user = User::create($input);

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->all();

        // dd($roles);

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $id,
            'password' => 'nullable|min:8|same:confirm-password',
            'roles' => 'required|array', // Ensure roles is an array
        ]);

        $input = $request->except(['_token', '_method']); // Exclude unnecessary fields

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $roles = $input['roles'];
        unset($input['roles'], $input['confirm-password']);

        $user = User::findOrFail($id);
        $user->update($input);


        // Ensure proper role IDs are passed
        $roleIds = array_map('intval', $validate['roles']);

        // Sync roles
        $user->roles()->sync($roleIds);

        return redirect()->route('users.index')
            ->with('update', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deactivate successfully');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'User restored successfully');
    }
}
