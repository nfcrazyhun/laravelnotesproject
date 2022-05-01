<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\NoteStatus;
use App\Http\Controllers\ApiController;
use App\Http\Transformers\NoteTransformer;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

/**
 * @group Notes
 *
 * APIs to manage Notes
 *
 * @authenticated
 */
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
     * @response 200 {
        "0": [
            {
                "id": 1,
                "user_id": 1,
                "body": "Consequatur dignissimos itaque nostrum explicabo illo.",
                "status": 2
            },
            {
                "id": 2,
                "user_id": 1,
                "body": "Voluptatem ut corporis expedita explicabo consequuntur.",
                "status": 1
            }
        ],
        "paginator": {
            "total_count": 4,
            "total_pages": 1,
            "current_page": 1,
            "limit": 15
        }
    }
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
     * @response 201 {
        "response": {
            "message": "Note created",
            "status_code": 201
        }
    }
     *
     * @response 422 {
        "error": {
            "message": [
                "The body field is required.",
                "The status field is required."
            ],
            "status_code": 422
        }
    }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => ['required','max:255'],
            'status' => ['required', new Enum(NoteStatus::class)],
        ]);

        if($validator->fails()){
            return $this->respondInvalidRequest($validator->errors()->all());
        }

        auth('sanctum')->user()->notes()->create([
            'body' => $request->body,
            'status' => $request->status,
        ]);

        return $this->responseCreated('Note created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @response 200 {
        "response": {
            "data": {
                "id": 2,
                "user_id": 1,
                "body": "Consequatur dignissimos itaque updated!",
                "status": 1
            },
            "status_code": 200
        }
    }
     *
     * @response 403 {
        "error": {
            "message": "This action is unauthorized.",
            "status_code": 403
        }
    }
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Note $note)
    {
        $this->authorizeForUser(auth('sanctum')->user(),'update', $note);

        //validation
        $validator = Validator::make($request->all(), [
            'body' => ['sometimes','required','max:255'],
            'status' => ['sometimes','required', new Enum(NoteStatus::class)],
        ]);

        if($validator->fails()){
            return $this->respondInvalidRequest($validator->errors()->all());
        }

        $note->update(
            $validator->getData()
        );

        return $this->respondWithData($this->noteTransformer->transform($note));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @response 200 {
        "response": {
            "message": "Note deleted",
            "status_code": 200
        }
    }
     *
     * @response 403 {
        "error": {
            "message": "This action is unauthorized.",
            "status_code": 403
        }
    }
     *
     * @param \App\Models\Note $note
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Note $note)
    {
        $this->authorizeForUser(auth('sanctum')->user(),'delete', $note);

        $note->delete();

        return $this->respondWithMessage('Note deleted');
    }
}
