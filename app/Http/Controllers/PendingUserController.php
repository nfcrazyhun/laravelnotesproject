<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function store()
    {
        $invCode = auth()->id() . Str::random(32);

        User::create([
            'name' => "--pending-user--",
            'username' => "--pending-user--",
            'email' => "--pending-user--",
            'password' => '--pending-user--',
            'invitation_code' => $invCode,
            'parent_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Invitation generated successfully! Code: '.$invCode);
    }
}
