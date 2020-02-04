<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $httpCode = Response::HTTP_OK;
    protected $pagination = [];

    public function getHttpCode()
    {
        return $this->httpCode;
    }

    public function setHttpCode($statusCode)
    {
        $this->httpCode = $statusCode;
        return $this;
    }

    public function respondWithErrors($code = '000', $errors = [], $header = [], $data = [])
    {
        return $this->respond(Api::error($code, $errors, $data), $header);
    }

    public function respond($data, $header = [])
    {
        return \Response::json($data, $this->getHttpCode(), $header);
    }

    public function setPagination($pagination)
    {
        $this->pagination = $pagination;
        return $this;
    }

    public function respondData($message = "", $data = [], $header = [])
    {
        return  $this->respond(Api::success($message, $data, $this->pagination), $header);
    }
}
