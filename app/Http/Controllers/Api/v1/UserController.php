<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;

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
