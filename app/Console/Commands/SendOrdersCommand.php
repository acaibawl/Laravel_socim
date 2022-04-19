<?php

namespace App\Console\Commands;

use App\UseCases\SendOrderUseCase;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-orders {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '購入情報を送信する';

    /** @var SendOrderUseCase */
    private SendOrderUseCase $useCase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendOrderUseCase $useCase)
    {
        parent::__construct();

        $this->useCase = $useCase;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date');
        $targetDate = Carbon::createFromFormat('Ymd', $date);
        $this->useCase->run($targetDate);
        $this->info('ok');
    }
}
