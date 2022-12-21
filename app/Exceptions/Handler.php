<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // HasShowroomException::class,
        // NoShowroomException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'phone_number',
        'password_confirmation',
    ];

    public function register() {
        $this->reportable(function(Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }

    public function render($request, Throwable $e)
    {
        if (in_array(App::environment(), ['local','testing'])) {
            $debug = config('app.debug');
        } else {
            $debug = false;
        }
        $debug = true;

        if ($debug & in_array(get_class($e), $this->dontReport)) { // if It Shouldnt be reported
            return parent::render($request, $e);
        }

        // check If custom validation

        if($e instanceof AuthorizationException) { // Defined Exception
            return parent::render($request, $e);
        }
        if($e instanceof AccessDeniedHttpException) {
            return response()->json(apiRes('error', 'Akses dibatasi'), 400);
        }

        if ($request->is('api/*') | $request->expectsJson()) {  // Defined Exception
            if ($e instanceof MethodNotAllowedHttpException) {
                return response()->json(apiRes("error", 'The specified method for the request is invalid', 'err_sys'), 405);
            }

            if ($e instanceof NotFoundHttpException) {
                return response()->json(apiRes("error", 'URL tidak ditemukan', 'err_sys'), 404);
            }

            if ($e instanceof HttpException) {
                return response()->json(apiRes("error", $e->getMessage()), $e->getStatusCode());
            }

            if ($e instanceof ModelNotFoundException) { // trigger from findOrFail firstOrFail()
                $model = $e->getModel()::$getName ?? "Data";
                return response()->json(apiRes("error", "$model tidak ditemukan"), 400);
            }

            if ($e instanceof ValidationException) {
                return response()->json(apiRes('error_val', $e->errors()), 400);
            }
        }

        if ($request->is('*ajax*') | $request->expectsJson()) {
            if ($e instanceof ValidationException) {
                return response()->json(apiRes('error_val', $e->errors()), 400);
            }
        }

        if ($e instanceof ValidationException) {
            return response()->json(apiRes('error_val', $e->errors()), 400);
        }

        // arbitrary respond !!
        $this->logMark($e, "Arbitrary!:");
        if (!$debug & $request->expectsJson()) {
            return response()->json(apiRes("error", $this->err_msg , 'err_sys'), 500);
        }

        return parent::render($request, $e);
    }

    protected function getUserId()
    {
        $user = Auth::user();
        if($user){
            return $user->id;
        }
        return null;
    }

    protected function mark($kode) {
        return "Error Code $kode ";
    }

    protected function logMark($e, $context) {
        $kode=date('dh-is')."-".mt_rand(1000,9999);
        Log::channel('daily')->error($this->mark($kode).": ".$e);
        $this->err_msg="Internal Error. Mohon hubungi Customer Service. Code: ".$kode;

        return true;
    }
}
