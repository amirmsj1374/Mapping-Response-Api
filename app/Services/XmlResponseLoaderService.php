<?php

namespace App\Services;

use App\Interfaces\ResponseLoaderInterface;
use GuzzleHttp\Psr7\Response;

class XmlResponseLoaderService implements ResponseLoaderInterface
{
    public function getData($response)
    {
        return 'XML loaded';
    }

    public function convertToArray($response)
    {
        return 'XML loaded';
    }
}
