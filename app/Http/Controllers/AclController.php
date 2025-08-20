<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AclController extends Controller
{
    public function getURL(string $url)
    {
        $response = Http::get('https://api-legends.visityar.com/' . $url);

        return $response->collect();
    }

    public function postURL(string $url)
    {
        $response = Http::post('https://api-legends.visityar.com/' . $url);

        return $response->body();
    }
}
