<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Model\PointEvent;
use App\Eloquent\CustomerPoint;
use App\Eloquent\CustomerPointEvent;
use App\Services\AddPointService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPointServiceWithMockTest extends TestCase
{
    use RefreshDatabase;

    private $customerPointEventMock;
    private $customerPointMock;

    protected function setUp()
    {
        // 1 Eloquentのモック化
        $this->customerPointEventMock = new class extends CustomerPointEvent
        {
            public PointEvent $pointEvent;

            public function register(PointEvent $event)
            {
                $this->pointEvent = $event;
            }

            public function getConnection()
            {
                return CustomerPointEvent::first()->getConnection();
            }
        };

        $this->customerPointMock = new class extends CustomerPoint
        {
            public int $customerId;
            public int $point;

            public function addPoint(int $customerId, int $point): bool
            {
                $this->customerId = $customerId;
                $this->point = $point;

                return true;
            }
        };
    }

    /**
     * @test
     */
    public function add()
    {
        // 2 テスト対象メソッドの実行
        $customerId = 1;
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            10,
            Carbon::create(2018, 8, 4, 12, 34, 56)
        );
        $service = new AddPointService(
            $this->customerPointEventMock,
            $this->customerPointMock
        );
        $service->add($event);

        // アサーション
        $this->assertEquals($event, $this->customerPointEventMock->pointEvent);
        $this->assertSame($customerId, $this->customerPointEventMock->customerId);
        $this->assertSame(10, $this->customerPointMock->point);
    }
}
