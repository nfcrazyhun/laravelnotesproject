<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @group PendingUser
 *
 * APIs to manage pending (invited) users
 *
 * @authenticated
 */
class PendingUserController extends ApiController
{
    protected $userTransformer;

    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @response 200{
    "0": [
            {
                "id": 11,
                "name": "--pending-user--",
                "username": "--pending-user--",
                "email": "--pending-user--",
                "parent_id": 1,
                "invitation_code": "1nNRsCndE9LT6w71NSId9fONa66RhrnfT"
            },
            {
                "id": 12,
                "name": "--pending-user--",
                "username": "--pending-user--",
                "email": "--pending-user--",
                "parent_id": 1,
                "invitation_code": "100Oe72cN9keSJIn4gPV4P13EKrRtbY3j"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $currentUser = auth('sanctum')->user();

        $users = User::where('parent_id', $currentUser->id)->whereNotNull('invitation_code')->paginate();

        return $this->respondWithPagination($users, [
            $this->userTransformer->transformCollection($users->items())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @response 200{
    "response": {
        "data": {
            "code": "100Oe72cN9keSJIn4gPV4P13EKrRtbY3j"
        },
        "status_code": 200
        }
    }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $currentUser = auth('sanctum')->user();

        $invCode = $currentUser->id . Str::random(32);

        User::create([
            'name' => "--pending-user--",
            'username' => "--pending-user--",
            'email' => "--pending-user--",
            'password' => '--pending-user--',
            'invitation_code' => $invCode,
            'parent_id' => $currentUser->id,
        ]);

        return $this->respondWithData(['code' => $invCode]);
    }
}
