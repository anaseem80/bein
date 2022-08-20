<?php

namespace App\Models;

use App\Models\Device;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Package;
use App\Models\Category;
use App\Models\UserBeinCard;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail
class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'email',
        'google_id',
        'facebook_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function channels(){
        return $this->hasMany(Channel::class,'created_by','id');
    }

    public function packages(){
        return $this->hasMany(Package::class,'created_by','id');
    }

    public function devices(){
        return $this->hasMany(Device::class,'created_by','id');
    }

    public function categories(){
        return $this->hasMany(Category::class,'created_by','id');
    }

    public function blogs(){
        return $this->hasMany(Blog::class,'created_by','id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'created_by','id');
    }

    public function beinCards(){
        return $this->hasMany(UserBeinCard::class,'user_id','id');
    }
}
