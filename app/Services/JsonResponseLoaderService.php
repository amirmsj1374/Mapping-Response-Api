<?php

namespace App\Services;

use App\Interfaces\ResponseLoaderInterface;
use GuzzleHttp\Psr7\Response;

class JsonResponseLoaderService implements ResponseLoaderInterface
{
    /**
     * To get json data and return it as an array
     */
    public function getData(Response $response) :array
    {
        return $this->convertToArray($response);
    }

    private function convertToArray(Response $response) :array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
