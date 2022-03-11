<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamResponseAction extends Controller
{
    public function __invoke(): StreamedResponse
    {
        return response()->stream(function() {
            while(true) {
                echo 'data: ' . rand(1, 100) . '\n\n';
                ob_flush();
                flush();
                usleep(20000);
            }
        }, Response::HTTP_OK, [
            'content-type' => 'text/event-stream',
            'X-accel-Buffering' => 'no',
            'Cache-Controle' => 'no-cache',
        ]);
    }
}
