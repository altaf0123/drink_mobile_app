<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function render($request, Throwable $exception)
    {
        if ($request->is("api/*")) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => 0,
                    'message' => $exception->getMessage(),
//                    'data' => []
                ]);
            }elseif ($exception instanceof ValidationException){
                return response()->json([
                    'status' => 0,
                    'message' => $exception->validator->errors()->all()[0],
                 //   'data' => []
                ]);
            }
            elseif ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Wrong http method given',
//                    'data' => []
                ]);
            }elseif ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Given URL not found on server',
//                    'data' => []
                ]);
            }elseif($exception instanceof  AuthenticationException){
              return response()->json([
                  'status' => 0,
                  'message' => $exception->getMessage(),
//                  'data' => []
              ]);
            }elseif($exception instanceof  LikeableException){
                return response()->json([
                    'status' => 0,
                    'message' => $exception->getMessage(),
//                    'data' => []
                ]);
            }
            else{
                return response()->json([
                    'status' => 0,
                    'message' => $exception->getMessage() .' on line no '.$exception->getLine() ,
//                    'data' => []
                ]);
            }
        }
            return parent::render($request, $exception);


    }
}
