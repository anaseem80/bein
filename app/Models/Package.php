<?php

namespace App\Models;

use App\Models\Offer;
use App\Models\Device;
use App\Models\Channel;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'package_channels', 'package_id', 'channel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    // public function device()
    // {
    //     return $this->belongsTo(Device::class)->with('countries');
    // }
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'package_devices', 'package_id', 'device_id')->with('countries');
    }
    // public function subPackages()
    // {
    //     return $this->hasMany(Package::class, 'parent_id');
    // }
    // public function parentPackage()
    // {
    //     return $this->belongsTo(Package::class, 'parent_id');
    // }
    public function allComments()
    {
        return $this->hasMany(Comment::class, 'item_id', 'id');
    }
    public function comments()
    {
        return $this->allComments()->with('user')->where('type', 'packages')->latest();
    }
    public function channelImages()
    {
        return $this->belongsToMany(ChannelImage::class, 'package_channel_images', 'package_id', 'channel_image_id');
    }
    public function offers(){
        return $this->hasMany(Offer::class,'package_id','id');
    }
    public function activeOffers()
    {
        return $this->offers()->where('status', 1)->latest();
    }
}
