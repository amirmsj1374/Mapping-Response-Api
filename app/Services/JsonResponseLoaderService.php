<?php

namespace App\Services;

use App\Interfaces\ResponseLoaderInterface;
use GuzzleHttp\Psr7\Response;

class JsonResponseLoaderService implements ResponseLoaderInterface
{
    public function getData(Response $response)
    {
        return $this->convertToArray($response);
    }

    public function convertToArray(Response $response) :array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
