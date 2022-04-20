<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = auth()->user()->descendantsAndSelf()->paginate();

        return view('users.index', compact('users'));
    }
}
