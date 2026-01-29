<?php

namespace App\Controllers;

use App\Models\User;
use Core\Http\Request;
use Core\Http\Response;
use Core\Validation\Validator;

/**
 * Dashboard Controller
 *
 * Protected dashboard with user CRUD operations
 */
class DashboardController
{
    /**
     * Show dashboard with user list
     */
    public function index(Request $request): Response
    {
        $users = User::all();

        return Response::view('dashboard/index', [
            'title' => 'Dashboard - ' . config('app.name'),
            'user' => auth()->user(),
            'users' => $users,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    /**
     * Show edit form for a user
     */
    public function edit(Request $request, int $id): Response
    {
        $user = User::find($id);

        if (!$user) {
            return redirect(url('/dashboard'))
                ->with('error', 'User not found.');
        }

        return Response::view('dashboard/edit', [
            'title' => 'Edit User - ' . config('app.name'),
            'currentUser' => auth()->user(),
            'editUser' => $user,
            'errors' => session('errors', []),
            'old' => session('_old_input', []),
        ]);
    }

    /**
     * Update a user
     */
    public function update(Request $request, int $id): Response
    {
        $user = User::find($id);

        if (!$user) {
            return redirect(url('/dashboard'))
                ->with('error', 'User not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect(url('/dashboard/users/' . $id . '/edit'))
                ->withErrors($validator->errors())
                ->withInput();
        }

        // Update user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect(url('/dashboard'))
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user
     */
    public function destroy(Request $request, int $id): Response
    {
        $user = User::find($id);

        if (!$user) {
            return redirect(url('/dashboard'))
                ->with('error', 'User not found.');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect(url('/dashboard'))
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect(url('/dashboard'))
            ->with('success', 'User "' . $userName . '" deleted successfully.');
    }
}
