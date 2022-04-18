<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Builder;

class NoteTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $users = auth()->user()->descendantsAndSelf()->orderBy('id')->get();

        $selectedUser = User::where('username', $request->get('username'))->first();

        $notes = $selectedUser?->notes()
            ->when(auth()->user()->id !== $selectedUser->id, function ($query, $selectedUser) {
                $query->public();
            })->paginate();

        return view('notes-tree.index', compact(['notes', 'users']));
    }

}
