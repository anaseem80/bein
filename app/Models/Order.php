<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Country;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts=[
        'invoice_details'=>'object'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
