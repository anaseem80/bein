<?php

namespace App\Models;

use App\Models\Device;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function devices()
    {
        return $this->belongsToMany(Device::class, 'device_countries', 'country_id', 'device_id');
    }
}
