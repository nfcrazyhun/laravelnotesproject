<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\NoteStatus;
use App\Http\Controllers\ApiController;

class NoteStatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $statuses = NoteStatus::cases();

        return $this->respond($statuses);
    }
}
