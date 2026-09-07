<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        if (! $user->show_in_directory) {
            abort(404);
        }

        $users = User::whereNotIn('id', [$user->id])
            ->inRandomOrder()
            ->select('name', 'role_title', 'slug')
            ->take(4)
            ->get();

        return view('users.show', compact('user', 'users'));
    }
}
