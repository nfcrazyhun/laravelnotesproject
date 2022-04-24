<?php

namespace App\Http\Controllers;

use App\Enums\NoteStatus;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $notes = auth()->user()->notes()->paginate();

        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'body' => 'required|max:255',
            'status' => ['required', new Enum(NoteStatus::class)],
        ]);

        auth()->user()->notes()->create([
            'body' => $request->body,
            'status' => $request->status,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Note $note)
    {
        $this->authorizeForUser(auth()->user(),'view', $note);

        $statuses = NoteStatus::cases();

        return view('notes.edit', compact(['note','statuses']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeForUser(auth()->user(),'update', $note);

        //validation
        $request->validate([
            'body' => 'required|max:255',
            'status' => ['required', new Enum(NoteStatus::class)],
        ]);

        $note->update([
            'body' => $request->body,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Note updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Note $note)
    {
        $this->authorizeForUser(auth()->user(),'delete', $note);

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted.');
    }
}
