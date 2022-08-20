<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageChannel extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table="package_channels";
}
