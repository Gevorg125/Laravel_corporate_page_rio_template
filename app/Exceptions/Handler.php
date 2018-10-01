<?php

namespace Corp\Exceptions;

use Corp\Menu;
use Corp\Repositories\MenusRepository;
use Exception;
use Corp\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {


        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($this->isHttpException($exception)){
            $status_code = $exception->getStatusCode();

            switch ($status_code){
                case '404':

                    //kstananq Menu objekt@, vor irancic vercnenq menu nkarelu logikan,, $obj->getMenu() functiayov
                    $obj = new SiteController(new MenusRepository(new Menu()));
                    $navigation = view(env('THEME').'.navigation')->with('menu', $obj->getMenu())->render();

                    //Log filer@ /storage/logs/laravel.log
                    //kgrancvi not found ejer@ logeri mej
                    Log::alert('Page not found - '. $request->url());
                    return response()->view(env('THEME'). '.404', ['bar' => 'no', 'title' => 'Pge Not Found', 'navigation' => $navigation]);
            }
        }

        return parent::render($request, $exception);
    }
}
