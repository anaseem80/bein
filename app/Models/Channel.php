<?php

namespace App\Models;

use App\Models\Package;
use App\Models\ChannelImage;
use App\Models\PackageChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function packages(){
        return $this->belongsToMany(Package::class,'package_channels','channel_id','package_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function images(){
        return $this->hasMany(ChannelImage::class,'channel_id','id');
    }
}
