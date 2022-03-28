<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): JsonResponse
    {

        $code = $e->getCode();
        $codeMessage = null;
        $error = $e->getMessage();

        switch(true) {
            case $e instanceof ModelNotFoundException:
                $code = Response::HTTP_NOT_FOUND;
                $codeMessage = Response::$statusTexts[$code];
                break;
            case $e instanceof ValidationException:
                $code = Response::HTTP_UNPROCESSABLE_ENTITY;
                $codeMessage = Response::$statusTexts[$code];
                break;
        }


        return response()->json([
            'code' => $code,
            'code_message' => $codeMessage,
            'error' => $error
        ], $code);
    }
}
