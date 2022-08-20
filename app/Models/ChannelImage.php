<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChannelImage extends Model
{
    use HasFactory;
    protected $guarded=[];

    
    public function channel(){
        return $this->belongTo(Channel::class,'channel_id','id');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_channel_images', 'channel_image_id', 'package_id');
    }
}
