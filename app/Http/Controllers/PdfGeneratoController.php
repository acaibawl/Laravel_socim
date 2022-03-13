<?php

namespace App\Http\Controllers;

use App\Jobs\PdfGenerator;
use Illuminate\Http\Request;

class PdfGeneratoController extends Controller
{
    public function index()
    {
        $generator = new PdfGenerator(storage_path('pdf/sample.pdf'));
        // job実行指示
        dispatch($generator);
    }
}
