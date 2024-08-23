<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Elon extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

//    protected $fillable = [
//        'groupIds',
//        'message',
//        'creator_id',
//        'deleter_id'
//    ];

}
