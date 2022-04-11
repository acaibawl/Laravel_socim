<?php
declare(strict_types=1);

namespace App\Eloquent;

use App\Model\PointEvent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $event
 * @property int $point
 * @property string $created_at
 */
class CustomerPointEvent extends Model
{
    protected $table = 'customer_point_events';
    // 自動生成されるタイムスタンプは不要
    public $timestamps = false;

    public function register(PointEvent $event)
    {
        $new = $this->newInstance();
        $new->customer_id = $event->getCustomerId();
        $new->event = $event->getEvent();
        $new->point = $event->getPoint();
        $new->created_at = $event->getCreatedAt();
        $new->save();
    }
}
