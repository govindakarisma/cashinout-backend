<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cash extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug", "when", "amount", "description"];
    protected $dates = ['when'];
}
