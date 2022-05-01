<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\NoteTransformer;
use App\Services\NoteTreeService;
use Illuminate\Http\Request;

/**
 * @group NotesTree
 *
 * APIs to lists Notes Tree
 *
 * @authenticated
 */
class NoteTreeController extends ApiController
{
    protected NoteTransformer $noteTransformer;

    function __construct(NoteTransformer $noteTransformer)
    {
        $this->noteTransformer = $noteTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * List other users public (and your other) notes under your hierarchy
     *
     * @queryParam username string
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
                "body": "post form api updated",
                "status": 1
            }
        ],
        "paginator": {
            "total_count": 2,
            "total_pages": 1,
            "current_page": 1,
            "limit": 15
        }
    }
     *
     * @response 404 {
        "error": {
            "message": "Not Found!",
            "status_code": 404
        }
    }
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function index(Request $request, NoteTreeService $noteTreeService)
    {
        $user = auth('sanctum')->user();

        $selectedUser = $noteTreeService
                            ->querySelectedUserFromUserHierarchy($user, $request->get('username'))
                            ->firstOrFail();

        $notes = $noteTreeService->queryNotesFromUserHierarchy($user, $selectedUser)->paginate();

        return $this->respondWithPagination($notes, [
            $this->noteTransformer->transformCollection($notes->items())
        ]);
    }
}
