<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PendingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::where('parent_id', auth()->id())->whereNotNull('invitation_code')->paginate();

        return view('pending-users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserService $userService)
    {
        $pendingUser = $userService->createPendingUser(auth()->id());

        return redirect()->back()->with('success', 'Invitation generated successfully! Code: '.$pendingUser->invitation_code);
    }
}
