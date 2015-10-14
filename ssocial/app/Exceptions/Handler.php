<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Core\Log\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // echo var_dump($e);

        if ( $e instanceof \Core\Exception\RestException )
            return response()->json($e -> getResponse(), $e -> getCode());
            

        // var_dump($e);
        // if ($e instanceof ModelNotFoundException) {
        //     $e = new NotFoundHttpException($e->getMessage(), $e);
        // }

        if ( $e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException )
        {
            Log::addException(__FILE__, $e -> getMessage(), $e -> getStatusCode() );
            return response()->json(['error' => true, 'type' => 'MethodNotAllowedHttpException' ], $e -> getStatusCode());
        }

        if ( $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException )
        {
            Log::addException(__FILE__, $e -> getMessage(), $e -> getStatusCode() );
            return response()->json(['error' => true, 'type' => 'NotFoundHttpException' ], $e -> getStatusCode());
        }

        if ( $e instanceof \PDOException )
        {
            Log::addException(__FILE__, $e -> getMessage(), $e -> getCode() );
            return response()->json(['error' => true, 'type' => 'PDOException' ], 500);
        }

        return parent::render($request, $e);

        // return response()->json(['error' => true, 'type' => 'desconocido', 'message' => $e -> getMessage()], 500);
    }
}
