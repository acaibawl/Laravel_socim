<?php

namespace Tests\Unit;

use App\Eloquent\Customer;
use App\Eloquent\CustomerPoint;
use App\Model\PointEvent;
use App\Services\AddPointService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPointServiceTest extends TestCase
{
    use RefreshDatabase;

    const CUSTOMER_ID = 1;

    protected function setUp()
    {
        parent::setUp();
        // 1 テスト必要なレコードを登録
        factory(Customer::class)->create([
            'id' => self::CUSTOMER_ID,
        ]);
        factory(CustomerPoint::class)->create([
            'customer_id' => self::CUSTOMER_ID,
            'point' => 100,
        ]);
    }

    /**
     * @test
     * @throws \Throwabe
     */
    public function add()
    {
        // 2 テスト対象メソッドの実行
        $event = new PointEvent(
            self::CUSTOMER_ID,
            '加算イベント',
            10,
            Carbon::create(2018, 8, 4, 12, 34, 56)
        );
        // コンストラクタインジェクションしているクラスを用意させる為にコンテナで用意
        /** @var AddPointService */
        $service = app()->make(AddPointService::class);  
        $service->add($event);

        // テスト結果のアサーション
        $this->assertDatabaseHas('customer_point_events', [
            'customer_id' => self::CUSTOMER_ID,
            'event' => $event->getEvent(),
            'point' => $event->getPoint(),
            'created_at' => $event->getCreatedAt(),
        ]);
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => self::CUSTOMER_ID,
            'point' => 110,
        ]);
    }
}
