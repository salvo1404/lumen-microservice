<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Building success response with data
     *
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponseWithData($data, $code = Response::HTTP_OK)
    {
        return \response()->json(['data' => $data, 'status' => 'ok'], $code);
    }

	/**
	 * Building success response with message
	 *
	 * @param string $message
	 * @param int    $code
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function successResponseWithMessage($message, $code = Response::HTTP_OK)
	{
		return \response()->json(['message' => $message, 'status' => 'ok'], $code);
	}

	/**
	 * Building error response
	 *
	 * @param string $message
	 * @param int    $code
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function errorResponse($message, $code)
    {
        return \response()->json(['error' => $message, 'code' => $code], $code);
    }

}
