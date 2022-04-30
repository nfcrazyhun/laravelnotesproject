<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Global route model binding ModelNotFound exception handling for Json API
         *
         * https://laraveldaily.com/laravel-api-404-response-return-json-instead-of-webpage-error/
         * https://www.youtube.com/watch?v=SlBJrLnyoMk
        */
        if ( request()->wantsJson() ) {
            $this->renderable(function (NotFoundHttpException $e) {
                return (new \App\Http\Controllers\ApiController())->responseNotFound();
            });
        }

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
