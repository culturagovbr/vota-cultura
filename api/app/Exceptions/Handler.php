<?php

namespace App\Exceptions;

use App\Modules\Core\Exceptions\EJsonException;
use App\Modules\Core\Exceptions\EModeloNaoEncontrado;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

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
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof EJsonException) {
            return $exception->render($request);
        }

        if ($exception instanceof ModelNotFoundException) {
            return (new EModeloNaoEncontrado())->render($request);
        }
        return parent::render($request, $exception);
    }
}
