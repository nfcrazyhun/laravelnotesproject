<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\NoteStatus;
use App\Http\Controllers\ApiController;
use App\Http\Transformers\NoteTransformer;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class NoteController extends ApiController
{
    protected NoteTransformer $noteTransformer;

    function __construct(NoteTransformer $noteTransformer)
    {
        $this->noteTransformer = $noteTransformer;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notes = auth('sanctum')->user()->notes()->paginate();

        return $this->respondWithPagination($notes, [
            $this->noteTransformer->transformCollection($notes->items())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            'body' => 'required|max:255',
            'status' => ['required', new Enum(NoteStatus::class)],
        ]);

        auth('sanctum')->user()->notes()->create([
            'body' => $request->body,
            'status' => $request->status,
        ]);

        return $this->responseCreated('Note created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeForUser(auth('sanctum')->user(),'update', $note);

        //validation
        $request->validate([
            'body' => 'required|max:255',
            'status' => ['required', new Enum(NoteStatus::class)],
        ]);

        $note->update([
            'body' => $request->body,
            'status' => $request->status,
        ]);

        return $this->respond($this->noteTransformer->transform($note));
    }
}
