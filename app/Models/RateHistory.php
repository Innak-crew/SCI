<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateHistory extends Model
{
    use HasFactory;

    protected $table = 'rate_histories';

    protected $fillable = [
        'order_item_id', 'rate_per', 'effective_date',
    ];

    // Relationship to the order item

    public function orderItem()
    {
        return $this->belongsTo(OrderItems::class, 'order_item_id');
    }
}
