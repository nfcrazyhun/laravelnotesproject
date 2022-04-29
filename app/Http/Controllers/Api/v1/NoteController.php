<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\NoteTransformer;
use App\Models\Note;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = auth('sanctum')->user()->notes()->paginate();

        return $this->respondWithPagination($notes, [
            $this->noteTransformer->transformCollection($notes->items())
        ]);
    }
}
