<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Handler {
    /**
     * Handle
     *
     * @param Exception $e
     * @param Request $request
     * @return void
     */
    public function handle(Exception $e, Request $request) 
    {
        /**
         * FORM VALIDATION
         */
        if ($e instanceof ValidationException) {
            return $this->format($e->errors(), $e->getMessage(), 422);
        }

        /**
         * DISPLAY ERROR
         */
        if ($e instanceof Exception) {
            return $this->format(
                [], 
                $e->getMessage(), 
                $e->getCode() > 0 ? $e->getCode() : 422
            );
        }
        
        return $this->format(
            [], 
            $e->getMessage(), 
            $e->getCode() > 0 ? $e->getCode() : 500
        );
    }

    /**
     * @param array $data
     * @param string $message
     * @param integer $code
     * @param array $headers
     * @return void
     */
    protected function format(
        array $data, 
        string $message, 
        int $code,
        array $headers = []
    ) {
        return new Response(
            json_encode([
                'status' => false,
                'message' => $message,
                'data' => $data
            ]), 
            $code,
            array_merge(['Content-Type' => 'application/json'], $headers)
        );
    }
}
