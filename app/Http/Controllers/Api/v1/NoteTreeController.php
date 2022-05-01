<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\NoteTransformer;
use App\Models\User;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function index(Request $request)
    {
        $users = auth('sanctum')->user()->descendantsAndSelf()->orderBy('id')->get();

        $userIdsInMyHierarchy = $users->pluck('id');

        $selectedUser = User::query()
            ->whereIn('id', $userIdsInMyHierarchy)
            ->where('username', $request->get('username'))
            ->firstOrFail();

        $notes = $selectedUser?->notes()->with('user')
            ->when(auth('sanctum')->user()->id !== $selectedUser->id, function ($query) {
                $query->public();
            })->paginate();

        return $this->respondWithPagination($notes, [
            $this->noteTransformer->transformCollection($notes->items())
        ]);
    }
}
