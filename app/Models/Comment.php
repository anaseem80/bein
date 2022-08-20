<?php

namespace App\Models;

use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function userDeletes()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function packages()
    {
        return $this->belongsTo(Package::class, 'item_id', 'id');
    }

    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'item_id', 'id');
    }
}
