<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
    /**
     * Return response
     *
     * @param JsonResource $jsonResource
     * @param integer $httpCode
     * @param string $message
     * @param boolean $status
     * @return JsonResource
     */
    protected function responseJsonResource(JsonResource $jsonResource, $httpCode = 200, $message = 'Success', $status = true) 
    {  
        if(is_null($jsonResource->resource)) {
            $data = [];
        } else {    
            $data = $jsonResource;
        }
        $result = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        return $this->response($result, $httpCode);
    }

    /**
     * Return response
     *
     * @param mixed $data
     * @param integer $httpCode
     * @param string $message
     * @param boolean $status
     * @return JsonResource
     */
    protected function responseJson($data, $httpCode = 200, $message = 'Success', $status = true) 
    {  
        $result = array(
            'status' => $status,
            'message' => $message,
            'data' => $data
        );
        return $this->response($result, $httpCode);
    }

    /**
     * Response
     *
     * @param string $content
     * @param integer $status
     * @param array $headers
     * @return string
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        return new Response(json_encode($content), $status, array_merge(['Content-Type' => 'application/json'], $headers));
    }
    
}
