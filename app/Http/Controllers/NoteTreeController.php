<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NoteTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $users = User::all();
        $selectedUser = User::where('username', $request->get('username'))->first();

        $notes = $selectedUser?->notes()->paginate();

        return view('notes-tree.index', compact(['notes', 'users']));
    }

}
