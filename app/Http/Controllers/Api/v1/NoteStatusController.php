<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\NoteStatus;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Arr;
use ReflectionEnum;

class NoteStatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $statuses = array();

        foreach (NoteStatus::cases() as $enum) {
            $statuses[] = [
                $enum->value => $enum->getName(),
            ];
        }

        return $this->respondWithData($statuses);
    }
}
