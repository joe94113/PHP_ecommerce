<?php

namespace App\Exceptions;

use App\Models\LogError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()  // 當發生錯誤訊息處理的程式
    {
        $this->reportable(function (Throwable $exception) {
            $user = auth()->user();  // 取得目前使用者
            LogError::create([
                'user_id' => $user ? $user->id : 0,
                'message' => $exception->getMessage(),  // 取得錯誤物件訊息
                'exception' => get_class($exception), // 取得錯誤在哪個class
                'line' => $exception->getLine(),  // 取得錯誤在第幾行
                'trace' => array_map(function ($trace) {
                    unset($trace['args']);  // 移除args參數value
                    return $trace;
                }, $exception->getTrace()),
                'method' => request()->getMethod(),
                'params' => request()->all(),
                'uri' => request()->getPathInfo(),
                'user_agent' => request()->userAgent(),
                'header' => request()->headers->all(),
            ]);
        });

        $this->renderable(function (Throwable $exception) {
            return response()->view('error');
        });
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        return response('授權失敗', 401);
    }
}
