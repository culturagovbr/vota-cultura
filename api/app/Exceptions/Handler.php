<?php

namespace App\Exceptions;

use App\Modules\Core\Exceptions\EJsonException;
use Exception;
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
     */
    public function render($request, Exception $exception) : \Illuminate\Http\Response
    {
        if ($exception instanceof EJsonException)
        {
            return $exception->render($request);
        }
        return parent::render($request, $exception);
    }
}
