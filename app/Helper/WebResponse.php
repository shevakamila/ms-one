<?php

namespace App\Http\Helper;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use stdClass;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WebResponse
{


    public static function successView(View $view, $data = null, $message = null)
    {
        return $view->with([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Send error response.
     *
     * @param  \Illuminate\View\View  $view
     * @param  string|null  $message
     * @param  mixed|null  $errors
     * @return \Illuminate\View\View
     */
    public static function errorView(View $view, $message = null, $errors = null)
    {
        return $view->with([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}
