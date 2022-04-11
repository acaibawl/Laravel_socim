<?php

namespace Tests\Unit;

use App\Eloquent\Customer;
use App\Eloquent\CustomerPointEvent;
use App\Model\PointEvent;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerPointEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function register()
    {
        // 1 テストに必要なレコードを登録
        $customerId = 1;
        factory(Customer::class)->create([
            'id' => $customerId,
        ]);

        // 2 テスト対象メソッドの実行
        $event = new PointEvent(
            $customerId,
            '加算イベント',
            100,
            Carbon::create(2018, 8, 4, 12, 34, 56)
        );
        $sut = new CustomerPointEvent();
        $sut->register($event);

        // 3 テスト結果のアサーション
        $this->assertDatabaseHas('customer_point_events', [
            'customer_id' => $customerId,
            'event' => $event->getEvent(),
            'point' => $event->getPoint(),
            'created_at' => $event->getCreatedAt(),
        ]);
    }
}
