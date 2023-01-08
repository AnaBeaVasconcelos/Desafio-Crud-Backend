<?php

namespace App\Http\Responses;

use App\Contracts\Exceptions\CustomException;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /*
    * @param $data
    * @param int $status
    * @param string $message
    * @return JsonResponse
    */
    public static function success($data = null, string $message = 'Sucesso', int $status = 200): JsonResponse
    {
        return response()->json([
            'status'    => true,
            'response'  => $data,
            'message'   => $message
        ], $status);
    }

    /*
    * @param $data
    * @param string $message
    * @param int $status
    * @param bool $paramError
    * @return JsonResponse
    */
    public static function error($data = null, string $message = 'Error', int $status = 400, bool $paramError = false): JsonResponse
    {
        if ($data instanceof \Throwable)
            return response()->json([
                'status'        => false,
                'response'      => self::mountErrorResponse($data),
                'message'       => $data instanceof CustomException ? $data->getMessage() : $message,
                'paramError'    => $data instanceof CustomException
            ],
                $data instanceof CustomException ? $status : 500);

        return response()->json([
            'status'        => false,
            'response'      => $data,
            'message'       => $message,
            'paramError'    => $paramError
        ], $status);
    }

    /**
     * @param \Throwable $exception
     * @return array
     */
    private static function mountErrorResponse(\Throwable $exception): array
    {
        return [$exception->getMessage()];
    }
}
