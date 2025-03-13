<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController
{
    public function users()
    {
        $users = User::with('products')->get();
        return view('admin.users', compact('users'));
    }
}
