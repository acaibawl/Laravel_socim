<?php

namespace App\Console\Commands;

use App\UseCases\SendOrderUseCase;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

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

    /** @var LoggerInterface */
    private LoggerInterface $logger;

    /** @var SendOrderUseCase */
    private SendOrderUseCase $useCase;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendOrderUseCase $useCase, LoggerInterface $logger)
    {
        parent::__construct();

        $this->useCase = $useCase;
        $this->logger = $logger;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->logger->info(__METHOD__ . ' ' . 'start');

        $date = $this->argument('date');
        $targetDate = Carbon::createFromFormat('Ymd', $date);
        $this->logger->info('TargerDate:' . $date);

        $count = $this->useCase->run($targetDate);
        $this->logger->info(__METHOD__ . ' ' . 'done sent_count: ' . $count);
    }
}
