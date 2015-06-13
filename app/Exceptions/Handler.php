<?php namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {

            $code = empty($e->getCode()) ? 404 : $e->getCode();

            return response()->view('errors.displayError', ['code' => $code, 'message' => "We're sorry but the page you were looking for could not be found"], $code);
        }
        if ($e instanceof HttpException) {

            switch ($e->getStatusCode()) {

                case 503: {

                    return response()->view('errors.displayError', ['code' => 503, 'message' => "The site is not available at the moment. Please come back later"], 404);
                }
                case 404: {

                    return response()->view('errors.displayError', ['code' => 404, 'message' => "The page you are looking for was not found"], 404);
                }
            }
        }
        if ($e instanceof TokenMismatchException) {

            return response()->view('errors.displayError', ['code' => 500, 'message' => "We're sorry, but something went wrong and the page cannot be displayed."], 500);
        }
        return parent::render($request, $e);
    }

}
