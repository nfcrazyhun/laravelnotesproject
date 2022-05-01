<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\NoteStatus;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Arr;
use ReflectionEnum;

/**
 * @group NotesStatus
 *
 * APIs to list Notes Statuses
 *
 * @authenticated
 */
class NoteStatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @response 200 {
        "response": {
            "data": [
                {
                    "1": "Private"
                },
                {
                    "2": "Public"
                }
            ],
            "status_code": 200
        }
    }
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
