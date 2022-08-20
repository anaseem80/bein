<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function package(){
        return $this->belongsTo(Package::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
