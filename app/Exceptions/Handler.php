<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function invalidJson($request, ValidationException $exception)
    {
        $errors = $exception->errors();
        $data = [
            'code' => ERROR,
            'message' => current($errors)[0]
        ];
        return response()->json($data, 200);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // 验证异常
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            // $response = $exception->getResponse()->getData();
            // return adminApiReturn($response->code, $response->message);
        }

        // 验证异常
        if ($exception instanceof \App\Exceptions\ApiRequestException) {
            return apiReturn(ERROR, $exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
