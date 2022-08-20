<?php

namespace App\Models;

use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function package(){
        return $this->belongsTo(Package::class,'package_id','id');
    }
}
