<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Knp\Snappy\Pdf;

class PdfGenerator implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path = '';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Pdf $pdf)
    {
        // html形式でPDF出力を指定
        $pdf->generate(
            '<h1>Laravel</h1><p>Sample PDF Output.</p>', $this->path
        );
    }
}
