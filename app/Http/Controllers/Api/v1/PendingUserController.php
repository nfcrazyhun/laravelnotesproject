<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
