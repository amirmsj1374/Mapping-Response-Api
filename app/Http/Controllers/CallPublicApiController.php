<?php

namespace App\Http\Controllers;

use App\Facades\MappingFacade;
use App\Interfaces\ResponseLoaderInterface;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CallPublicApiController extends Controller
{
    public function index()
    {
        $client = new Client();

        $response = $client->request(
            'get',
            'https://api.publicapis.org/entries',
        );

        $originalAarray = resolve(ResponseLoaderInterface::class, [$response])->getData($response);
        return response()->json(MappingFacade::getData($originalAarray));
    }
}
