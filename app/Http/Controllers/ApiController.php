<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller
{
    protected $statusCode = 200; // HTTP_OK, default

    /**
     * Gets the value of statusCode.
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param mixed $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function responseNotFound($message = 'Not Found!') // 404
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message);
    }

    public function respondInvalidRequest($message = 'Invalid Request!') // 422
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }


    public function respondInternalError($message = 'Internal Error') // 500
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    protected function respondWithPagination(LengthAwarePaginator $items, array $data)
    {

        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $items->total(),
                'total_pages' => ceil($items->total() / $items->perPage()),
                'current_page' => $items->currentPage(),
                'limit' => $items->perPage()
            ]
        ]);

        return $this->respond($data);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondWithMessage($message='All is well.')
    {
        return $this->respond([
            'response' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * Find out the currently authenticated user from bearerToken.
     *
     * @return User
     * @deprecated Use "auth('sanctum')->user()" instead.
     */
    public function currentUser(): User
    {
        // Get bearer token
        $bearer = request()->bearerToken();

        // Fetch the associated token Model
        $token = \Laravel\Sanctum\PersonalAccessToken::findToken($bearer);

        // Get the assigned user
        $user = $token->tokenable;

        // Return the current User instance
        return $user;
    }

}
