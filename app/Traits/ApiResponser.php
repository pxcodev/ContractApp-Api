<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response as HttpResponse;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    static function success(string $title = null, $detail = null, int $code = 200, array $data = [])
    {
        return response()->json([
            'data' => [
                'status' => 'success',
                'title'  => $title,
                'detail' => $detail,
                'attributes' => $data,
                'code' =>  $code
            ]
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    static function error(string $title = null, $detail = null, int $code = 0)
    {
        return response()->json([
            'errors' => [
                'status' => 'error',
                'title'  => $title,
                'detail' => $detail,
                'code' =>  $code
            ]
        ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
}
