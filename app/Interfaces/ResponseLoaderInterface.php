<?php

namespace App\Interfaces;

use GuzzleHttp\Psr7\Response;

interface ResponseLoaderInterface
{
    public function getData(Response $response);
}
