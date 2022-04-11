<?php

namespace Tests\Unit;

use App\Eloquent\Customer;
use App\Eloquent\CustomerPoint;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerPointTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function addPoint()
    {
        // 1 テストに必要なレコードを登録
        $customerId = 1;
        factory(Customer::class)->create([
            'id' => $customerId,
        ]);
        factory(CustomerPoint::class)->create([
            'id' => $customerId,
            'point' => 100,
        ]);

        // 2 テスト対象メソッドの実行
        $pointModel = new CustomerPoint();
        $result = $pointModel->addPoint($customerId, 10);

        // テスト結果のアサーション
        $this->assertTrue($result);
        $this->assertDatabaseHas('customer_points', [
            'customer_id' => $customerId,
            'point' => 110,
        ]);
    }
}
