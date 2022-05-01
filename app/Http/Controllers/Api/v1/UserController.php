<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\UserTransformer;

/**
 * @group Users
 *
 * APIs to list users under your hierarchy
 *
 * @authenticated
 */
class UserController extends ApiController
{
    protected $userTransformer;

    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @response 200 {
    "0": [
            {
                "id": 1,
                "name": "Ms. Anderson",
                "username": "admin",
                "email": "admin@admin.com",
                "parent_id": null
            },
            {
                "id": 5,
                "name": "Chester Schaefer",
                "username": "beatrice.bahringer",
                "email": "lavada53@example.net",
                "parent_id": 1
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = auth()->user()->descendantsAndSelf()->paginate();

        return $this->respondWithPagination($users, [
            $this->userTransformer->transformCollection($users->items())
        ]);
    }
}
