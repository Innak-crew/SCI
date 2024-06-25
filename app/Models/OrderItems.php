<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'category_id',
        'design_id',
        'quantity',
        'rate_per',
        'discount_amount',
        'discount_percentage',
        'sub_total',
        'total',
    ];

    

    public function Order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function catagories(){
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function design(){
        return $this->belongsTo(Designs::class, 'design_id');
    }



}
 