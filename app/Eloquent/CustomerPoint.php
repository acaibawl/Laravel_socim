<?php
declare(strict_types=1);

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    protected $table = 'customer_points';
    // 自動生成されるタイムスタンプは不要
    public $timestamps = false;

    /**
     * @param int $customerId
     * @param int $point
     * @return bool
     */
    public function addPoint(int $customerId, int $point): bool
    {
        return $this->newQuery()
            ->where('customer_id', $customerId)
            ->update([
                'point' => $this->getConnection()->raw('point + ?', $point)
            ]) === 1;
    }
}
