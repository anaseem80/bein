<?php

namespace App\Models;

use App\Models\User;
use App\Models\Country;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'device_countries', 'device_id', 'country_id')->withPivot('shipping_price');
    }
    // public function packages()
    // {
    //     return $this->hasMany(Package::class);
    // }
    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_devices', 'device_id', 'package_id');
    }
    public function newTypePackages()
    {
        return $this->packages()->where('type','new')->orWhere('type','both');
    }
}
