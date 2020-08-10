<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
    // public function render($request, Throwable $exception)
    // {
    //     return parent::render($request, $exception);
    // }


    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->ajax()) {
            return $this->handleAPIExceptions($request, $exception);
        }
        return parent::render($request, $exception);
    }

    /**
     * @param $request
     * @param $exception
     *
     * @return \Illuminate\Http\Response|mixed
     */
    private function handleAPIExceptions($request, $exception)
    {

        if ($exception instanceof HttpException) {
            return $this->respondWithError(
                $exception->getMessage() ?? Response::statusTexts[$exception->getStatusCode()],
                $exception->getStatusCode()
            );
        } elseif ($exception instanceof ValidationException) {
            $error = collect($exception->validator->getMessageBag())->flatten();
            return $this->respondWithError($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        } elseif ($exception instanceof \Illuminate\Database\QueryException) {
            return $this->respondWithError('Some internal system error occurred. Please try again later', Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $model = str_replace("App\Models\\", '', $exception->getModel());
            return $this->respondWithError(sprintf('No results for %s', $model), Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($exception instanceof \Symfony\Component\Debug\Exception\FatalThrowableError) {
            return $this->respondWithError('Some things are missing. Please try again later', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }

    /**
     * Respond with a generic error
     *
     * @param string $message
     * @param $status_code
     *
     * @return mixed
     */
    private function respondWithError($message, $status_code)
    {
        return response()->json([
            'error' => [
                'message' => $message,
            ]
        ], $status_code);
    }
}